<?php

namespace App\Http\Controllers\Products;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Locale;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\Products\ShirtSpecification;
use \Debugbar;

class SpecificationController extends Controller
{
    protected $specification;
    // protected $agent;
    protected $paginate;
    protected $locale;
    protected $images;
    protected $locale_slug_seo;

    function __construct(ShirtSpecification $specification, Locale $locale, LocaleSlugSeo $locale_slug_seo)
    {
        $this->middleware('auth');
        $this->specification = $specification;
        // $this->agent = $agent;
        $this->locale = $locale;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale->setParent('specifications');
        $this->locale_slug_seo->setParent('specifications');

        // if ($this->agent->isMobile()) {
        //     $this->paginate = 10;
        // }

        // if ($this->agent->isDesktop()) {
        //     $this->paginate = 6;
        // }
    }

    public function index()
    {
        $view = View::make('admin.layout.specifications')
        ->with('specification', $this->specification)
        ->with('specifications', $this->specification->where('active', 1)->paginate($this->paginate));

        if(request()->ajax()) {
            
            $sections = $view->renderSections(); 

            return response()->json([
                // 'table' => $sections['table'],
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
        
        $specification = $this->specification->updateOrCreate([
            'id' => request('id')],[
            'product_number' => request('product_number'),
            'designer' => request('designer'),
            'active' => 1,
        ]);

        if(request('seo')){
            $seo = $this->locale_slug_seo->store(request('seo'), $specification->id, 'front_products');
        }

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $specification->id);
        }

        if (request('id')){
            $message = \Lang::get('admin/faqs.faq-update');
        }else{
            $message = \Lang::get('admin/faqs.faq-create');
        }

        $view = View::make('admin.layout.specifications')
        ->with('locale', $locale)
        ->with('specifications', $this->specification->where('active', 1)->paginate($this->paginate))
        ->with('specification', $specification)
        ->renderSections();        

        return response()->json([
            // 'table' => $view['table'],
            // 'form' => $view['form'],
            'message' => $message,
            'id' => $specification->id,
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

    // public function show(Faq $faq){
        
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