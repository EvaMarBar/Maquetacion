<?php

namespace App\Vendor\Image;

use Illuminate\Support\Facades\Storage;
use App\Vendor\Image\Models\ImageConfiguration;
use App\Vendor\Image\Models\ImageOriginal;
use App\Vendor\Image\Models\ImageResize;
use App\Jobs\ProcessImage;
use App\Jobs\DeleteImage;
use Jcupitt\Vips;
use Debugbar;

class Image
{
	protected $entity;
	protected $extension_conversion;
	
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}

	public function storeRequest($request, $extension_conversion, $foreign_id){

		$this->extension_conversion = $extension_conversion;
		
		foreach($request as $key => $file){

			$key = str_replace(['-', '_'], ".", $key); 
			$explode_key = explode('.', $key);
			$content = reset($explode_key);
			$language = end($explode_key);

			$image = $this->store($file, $foreign_id, $content, $language);
			$this->store_resize($file, $foreign_id, $content, $language, $image->path);
		}
	}

	public function store($file, $entity_id, $content, $language){

		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		$name = str_replace(" ", "-", $name);
		//Cambia el nombre a minusculas y los espacios por guiones
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
		//Cambia la extension a minuscula

		$filename = $name .'.'. $file_extension;
		//Lo junta para tener el nombre

		if($file_extension != 'svg'){
			$data = getimagesize($file);
			$width = $data[0];
			$height = $data[1];
		}
		//Como los svg no pierden calidad al estirarse no necesitamos hacer este paso. Si no es un svg cogemos el tamaño de la imagen. 
		//La tabla de t_image_configuration no tiene panel de administración, se rellenan a mano en el NaviCat.
		
		$settings = ImageConfiguration::where('entity', $this->entity)
		->where('content', $content)
		->where('grid', 'original')
		->first();
		//Settings devolverá la linmea de la configuración de imagen en la que esta la imagen.

		$path = '/' . $entity_id . '/' . $language . '/' . $content . '/original/' . $name . '.' . $file_extension;
		$path = str_replace(" ", "-", $path);
		//Crea el path que se va a seguir creando las carpetas que hagan falta para guardar la imagen.

		if($settings->type == 'single'){

			Storage::disk($this->entity)->deleteDirectory('/' . $entity_id . '/' . $language . '/' . $content . '/original');
			Storage::disk($this->entity)->putFileAs('/' . $entity_id . '/' . $language . '/' . $content . '/original', $file, $filename);

			$image = ImageOriginal::updateOrCreate([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'language' => $language,
				'content' => $content],[
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
			]);
		}
		//Si solo almacenamos una imagen. Laravel para guardar archivos usa storage, hay que poner el use arribe. Si hay una carpeta se elimina y se crea una nueva con la nueva imagen. Como guardar archivos en Laravel con storage es útil para otras cosas. Con disk creamos una carpeta cpor cada identidad, estos discos se declaran a mano en config>filesystems.php 

		elseif($settings->type == 'collection'){

			$counter = 2;
 
			while (Storage::disk($this->entity)->exists($path)) {
				
				$path = '/' . $entity_id . '/' . $language . '/' . $content . '/original/' . $name.'-'. $counter.'.'. $file_extension;
				$filename =  $name.'-'. $counter.'.'. $file_extension;
				$counter++;
			}

			Storage::disk($this->entity)->putFileAs('/' . $entity_id . '/' . $language . '/' . $content . '/original', $file, $filename);

			$image = ImageOriginal::create([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'language' => $language,
				'content' => $content,
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
			]);
		}

		return $image;
	}
	//Si hay mas de una imagen. Si existe el path con un archivo le añade el counter que es 2 y le sube uno a counter. Es por si hay dos objetos con el mismo nombre que se le cambie el nombre al segundo. El bucle se quedará comprobando hasta que llegue a un nombre que no este cogido. Además de guardar la imagen original y los datos te devuelve la imagen en la variable $image. 

	public function store_resize($file, $entity_id, $content, $language, $original_path){

		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
		$settings = ImageConfiguration::where('entity', $this->entity)
					->where('content', $content)
					->where('grid', '!=', 'original')
					->get();
		//Cambiamos el nombre como antes, y cogemos todos los que el grid no sea original.

		foreach ($settings as $setting => $value) {

			$content_accepted = explode("/", $value->content_accepted);
			//Es un array de 4 elementos.

			if(!in_array($file_extension, $content_accepted)){
				continue;
			}
			//Si la extension del archivo NO se encuentra en el content_accepted hace contine (es como un return, pero no para lo que hace en otro lado). Esto revisa que la extension del archivo sea de las que estan aceptadas. 
			
			if($file_extension == 'svg'){
				$directory = '/' . $entity_id . '/' . $language . $value->directory; 
				$path = $directory . '/' . $name . '.' . $file_extension;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $file_extension;
			}else{
				$directory = '/' . $entity_id . '/' . $language . $value->directory; 
				$path = $directory . '/' . $name . '.' . $this->extension_conversion;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $this->extension_conversion;
			}		
			//Si es svg no se transforma a otro tipo de imagen, si es otro tipo de imagen se transforma por $this->extension_conversion que se lo pasa el controlador en el segundo parámetro (webp por ejemplo).

			if($value->type == 'single'){

				ProcessImage::dispatch(
					$entity_id,
					$value->entity,
					$directory,
					$value->grid,
					$language, 
					$value->disk,
					$path, 
					$filename, 
					$value->content,
					$value->type,
					$file_extension,
					$this->extension_conversion,
					$value->width,
					$value->quality,
					$original_path, 
					$value->id
				)->onQueue('process_image');
			}
			//Para mandar algo a la cola hay que poner onQueue (nombre de la cola) y hay que crear la caprteta jobs con un archivo ProcessImages al que le pasamos todos los datos que necesita para hacer cosas cuando peuda (?). Para que funcione esto hay que instalar presis (controller), vips (muchas cosas, difícil), horizont (gestor de colas - composer) y surpevisor (apt). Una cola puede tener muchas tareas pero una tarea solo puede estar en una cola.
			
			elseif($value->type == 'collection'){

				$counter = 2;

				while (Storage::disk($value->disk)->exists($path)) {
					
					if($file_extension == 'svg'){
						$path =  '/' . $entity_id . '/' . $language . $value->directory . '/' . $name.'-'. $counter.'.'. $file_extension;
						$filename = $name .'-'. $counter.'.'. $file_extension;
						$counter++;
					}else{
						$path =  '/' . $entity_id . '/' . $language . $value->directory . '/' . $name.'-'. $counter.'.'. $this->extension_conversion;
						$filename = $name .'-'. $counter.'.'. $this->extension_conversion;
						$counter++;
					}		
				}

				ProcessImage::dispatch(
					$entity_id,
					$value->entity,
					$directory,
					$value->grid,
					$language, 
					$value->disk,
					$path, 
					$filename, 
					$value->content,
					$value->type,
					$file_extension,
					$this->extension_conversion,
					$value->width,
					$value->quality,
					$original_path, 
					$value->id
				)->onQueue('process_image');
			}
		}
	}

	public function show($entity_id, $language)
	{
		return ImageOriginal::getPreviewImage($this->entity, $entity_id, $language)->first();
	}

	public function preview($entity_id)
	{
		$items = ImageOriginal::getPreviewImage($this->entity, $entity_id)->pluck('path','language')->all();

        return $items;
	}

	public function galleryImage($entity, $grid, $entity_id, $filename)
	{
		
		$image = ImageOriginal::getGalleryImage($entity, $entity_id, $filename, $grid)->first();

		return response()->json([
			'path' => Storage::url($image->path),
		]); 
	}

	public function galleryPreviousImage($entity, $grid, $entity_id, $id)
	{		

		$image = ImageOriginal::getGalleryPreviousImage($entity_id, $entity, $grid, $id)->first();

		$previous = route('gallery_previous_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);
		$next = route('gallery_next_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);

		return response()->json([
			'path' => Storage::url($image->path),
			'previous' => $previous,
			'next' => $next
		]); 
	}

	public function galleryNextImage($entity, $grid, $entity_id, $id)
	{

		$image = ImageOriginal::getGalleryNextImage($entity_id, $entity, $grid, $id)->first();

		$previous = route('gallery_previous_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);
		$next = route('gallery_next_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);

		return response()->json([
			'path' => Storage::url($image->path),
			'previous' => $previous,
			'next' => $next
		]); 
	}

	public function original($entity_id)
	{
		$items = ImageOriginal::getOriginalImage($this->entity, $entity_id)->pluck('path','language')->all();

        return $items;
	}

	public function getAllByLanguage($language){ 

        $items = ImageOriginal::getAllByLanguage($this->entity, $language)->get()->groupBy('entity_id');

        $items =  $items->map(function ($item) {
            return $item->pluck('path','grid');
        });

        return $items;
    }

	public function destroy(ImageOriginal $image)
	{
		DeleteImage::dispatch($image->filename, $image->content, $image->entity)->onQueue('delete_image');

		$message = \Lang::get('admin/media.media-delete');

		return response()->json([
            'message' => $message,
        ]);
	}

	public function delete($entity_id)
	{
		if (ImageOriginal::getImages($this->entity, $entity_id)->count() > 0) {

			$images = ImageOriginal::getImages($this->entity, $entity_id)->get();

			foreach ($images as $image){
				Storage::disk($image->entity)->delete($image->path);
				$image->delete();
			}
		}
	}
}
