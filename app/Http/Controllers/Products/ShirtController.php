<?php

namespace App\Http\Controllers\Products;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Locale;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Vendor\Image\Image;
use App\Models\Products\Shirt;
use App\Vendor\Product\Product;
use App\Vendor\Product\Size;
use App\Vendor\Product\Colour;
use \Debugbar;

class ShirtController extends Controller
{
    protected $shirt;
    // protected $agent;
    protected $paginate;
    protected $locale;
    protected $images;
    protected $locale_slug_seo;
    protected $prodcut;
    protected $size;
    protected $colour;

    function __construct(Shirt $shirt, Locale $locale, Image $images, LocaleSlugSeo $locale_slug_seo, Product $product, Size $size, Colour $colour)
    {
        $this->middleware('auth');
        $this->shirt = $shirt;
        // $this->agent = $agent;
        $this->locale = $locale;
        $this->image = $images;
        $this->locale_slug_seo = $locale_slug_seo;
        $this->product = $product;
        $this->size = $size;
        $this->colour = $colour;

        $this->locale->setParent('shirts');
        $this->locale_slug_seo->setParent('shirts');
        $this->image->setEntity('shirts');

        // if ($this->agent->isMobile()) {
        //     $this->paginate = 10;
        // }

        // if ($this->agent->isDesktop()) {
        //     $this->paginate = 6;
        // }
    }

    public function index()
    {
        $view = View::make('admin.shirts.index')
        ->with('shirt', $this->shirt)
        ->with('shirts', $this->shirt->where('active', 1)->paginate($this->paginate));

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

      
    }

    public function store(Request $request)
    {            
        
        $shirt = $this->shirt->updateOrCreate([
            'id' => request('id')],[
            'category_id' => request('category_id'),
            'product_number' => request('product_number'),
            'designer' => request('designer'),
            'active' => 1,
        ]);

        if(request('size')){
            $size = $this->size->store(request('size'), $shirt->id);
        }
        

        if(request('colour')){
            $colour = $this->colour->store(request('colour'), $shirt->id);
        }
       
        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $shirt->id);
        }
        if(request('product')){
            $product = $this->product->store(request('product'), $shirt->id);
        }

        if(request('images')){
            
            $images = $this->image->store(request('images'), $shirt->id);
        }

        if(request('seo')){
            $seo = $this->locale_slug_seo->store(request('seo'), $shirt->id, 'front_product');
        }

        // if (request('id')){
        //     $message = \Lang::get('admin/faqs.faq-update');
        // }else{
        //     $message = \Lang::get('admin/faqs.faq-create');
        // }

        $view = View::make('admin.shirts.index')
        ->with('locale', $locale)
        ->with('product', $product)
        ->with('size', $size)
        ->with('colour', $colour)
        ->with('shirts', $this->shirt->where('active', 1)->paginate($this->paginate))
        ->with('shirt', $shirt)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            // 'message' => $message,
            'id' => $shirt->id,
        ]);
    }

    // public function edit(Faq $faq)
    // {
    //     $locale = $this->locale->show($faq->id);
    //     $seo = $this->locale_slug_seo->show($faq->id);


    //     $view = View::make('admin.faqs.index')
    //     ->with('locale', $locale)
    //     ->with('seo', $seo)
    //     ->with('faq', $faq)
    //     ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate));   
        
    //     if(request()->ajax()) {

    //         $sections = $view->renderSections(); 
    
    //         return response()->json([
    //             'form' => $sections['form'],
    //         ]); 
    //     }
                
    //     return $view;
    // }

    public function show(Shirt $shirt){
        
        $locale = $this->locale->show($shirt->id);
        $seo = $this->locale_slug_seo->show($shirt->id);
        $product = $this->product->show($shirt->id);
        $size = $this->size->show($shirt->id);
        $colour = $this->colour->show($shirt->id);


        $view = View::make('admin.shirts.index')
        ->with('locale', $locale)
        ->with('seo', $seo)
        ->with('product', $product)
        ->with('size', $size)
        ->with('colour', $colour)
        ->with('shirt', $shirt)
        ->with('shirts', $this->shirt->where('active', 1)->paginate($this->paginate));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    // public function destroy(Faq $faq)
    // {
    //     $faq->active = 0;
    //     $faq->save();

    //     $message = Lang::get('admin/faqs.faq-delete');

    //     $view = View::make('admin.faqs.index')
    //         ->with('faq', $this->faq)
    //         ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate))
    //         ->renderSections();
        
    //     return response()->json([
    //         'table' => $view['table'],
    //         'form' => $view['form']
    //     ]);
    // }


    // public function filter(Request $request, $filters = null){ //A??ades el $filters = null

    //     $filters = json_decode($request->input('filters')); //Aqui convertimos la url en json para poder encontrar los filtros
        
    //     $query = $this->faq->query();

    //     if($filters != null){
    //         /*No se porque pero Carlos ha cambiado la forma de escribir la busqueda de filtros as??
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

    //     //Para que te pagine bien tienes que poner la parte de appends, sino se te quitar?? el filtro
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