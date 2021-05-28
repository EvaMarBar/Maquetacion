<?php

namespace App\Http\Controllers\Products;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Locale;
use App\Vendor\Image\Image;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Http\Controllers\Products\SpecificationController;
use App\Models\Products\Product;
use \Debugbar;

class ProductController extends Controller
{
    protected $product;
    // protected $agent;
    protected $paginate;
    protected $locale;
    protected $images;
    protected $locale_slug_seo;
    protected $specification;

    function __construct(Product $product, Locale $locale, Image $images, LocaleSlugSeo $locale_slug_seo, SpecificationController $specification)
    {
        $this->middleware('auth');
        $this->product = $product;
        // $this->agent = $agent;
        $this->locale = $locale;
        $this->image = $images;
        // $this->locale_slug_seo = $locale_slug_seo;
        $this->specification =$specification;

        $this->locale->setParent('faqs');
        // $this->locale_slug_seo->setParent('faqs');
        $this->image->setEntity('faqs');

        // if ($this->agent->isMobile()) {
        //     $this->paginate = 10;
        // }

        // if ($this->agent->isDesktop()) {
        //     $this->paginate = 6;
        // }
    }

    public function index()
    {

        $view = View::make('admin.products.index')
                ->with('product', $this->product)
                ->with('products', $this->product->where('active', 1)->paginate($this->paginate));

        if(request()->ajax()) {
            
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }

    public function create()
    {

        $view = View::make('admin.products.index')
        ->with('product', $this->product)
        ->with('products', $this->product->where('active', 1)->paginate($this->paginate))
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(Request $request)
    {            
    
        $product = $this->product->updateOrCreate([
            'id' => request('id')],[
            'category_id' => request('category_id'),
            'original_price' => request('original_price'),
            'taxes' => request('taxes'),
            'discount' => request('discount'),
            'price' => request('price'),
            'visible' => request('visible'),
            'active' => 1,
        ]);

        
        if(request('specifications')){
            $specification = $this->specification->store(request('specification'), $product->id);
        }

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $product->id);
        }

        if(request('images')){
            
            $images = $this->image->store(request('images'), $product->id);
        }

        // if(request('seo')){
        //     $seo = $this->locale_slug_seo->store(request('seo'), $product->id, 'front_product');

        // }
        
        if (request('id')){
            $message = \Lang::get('admin/products.product-update');
        }else{
            $message = \Lang::get('admin/products.product-create');
        }

        $view = View::make('admin.products.index')
        ->with('locale', $locale)
        ->with('products', $this->product->where('active', 1)->paginate($this->paginate))
        ->with('product', $product)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
            'id' => $product->id,
        ]);
    }

    public function edit(Product $product)
    {
        $locale = $this->locale->show($product->id);
        $seo = $this->locale_slug_seo->show($product->id);


        $view = View::make('admin.products.index')
        ->with('locale', $locale)
        ->with('seo', $seo)
        ->with('product', $product)
        ->with('products', $this->product->where('active', 1)->paginate($this->paginate));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function show(Product $product){
        
        $locale = $this->locale->show($product->id);
        $seo = $this->locale_slug_seo->show($product->id);

        $view = View::make('admin.products.index')
        ->with('locale', $locale)
        ->with('seo', $seo)
        ->with('product', $product)
        ->with('products', $this->product->where('active', 1)->paginate($this->paginate));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(Product $product)
    {
        $product->active = 0;
        $product->save();

        $message = Lang::get('admin/products.product-delete');

        $view = View::make('admin.products.index')
            ->with('product', $this->product)
            ->with('products', $this->product->where('active', 1)->paginate($this->paginate))
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }


    // public function filter(Request $request, $filters = null){ //Añades el $filters = null

    //     $filters = json_decode($request->input('filters')); //Aqui convertimos la url en json para poder encontrar los filtros
        
    //     $query = $this->faq->query();

    //     if($filters != null){
    //         /*No se porque pero Carlos ha cambiado la forma de escribir la busqueda de filtros así
    //         Solo tienes que copiar esto con tus nombres y te deberia funcionar*/
    //         $query->when($filters->category_id, function ($q, $category_id) {

    //             if($category_id == 'all'){
    //                 return $q;
    //             }
    //             else {
    //                 return $q->where('category_id', $category_id);
    //             }
    //         });

    //         $query->when($filters->search, function ($q, $search) {

    //             if($search == null){
    //                 return $q;
    //             }
    //             else {
    //                 return $q->where('t_faqs.title', 'like', "%$search%");
    //             }
    //         });

            
    //         $query->when($filters->initial_date, function ($q, $initial_date) {

    //             if($initial_date == null){
    //                 return $q;
    //             }
    //             else {
    //                 return $q->whereDate('t_faqs.created_at', '>=', $initial_date);
                    
    //             }
    //         });

    //         $query->when($filters->final_date, function ($q, $final_date) {

    //             if($final_date == null){
    //                 return $q;
    //             }
    //             else {
    //                 return $q->whereDate('t_faqs.created_at', '<=', $final_date);
                    
    //             }
    //         });

    //         $query->when($filters->order, function ($q, $order) use ($filters) {

    //             $q->orderBy($order, $filters->direction);
    //         });


    //     }

    //     //Para que te pagine bien tienes que poner la parte de appends, sino se te quitará el filtro
    //     $faqs = $query->where('t_faqs.active', 1)->paginate($this->paginate)->appends(['filters' => json_encode($filters)]); 

    //     $view = View::make('admin.faqs.index')
    //         ->with('faqs', $faqs)
    //         ->renderSections();

    //     return response()->json([
    //         'table' => $view['table'],
    //     ]);
    // }
}

/*Ahora mismo lo de filtrar por fechas no me funciona si lo arreglo cambiare esto*/