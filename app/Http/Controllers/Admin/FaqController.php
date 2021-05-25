<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Locale;
use App\Vendor\Image\Image;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\DB\Faq;
use \Debugbar;

class FaqController extends Controller
{
    protected $faq;
    // protected $agent;
    protected $paginate;
    protected $locale;
    protected $images;

    function __construct(Faq $faq, Locale $locale, Image $images )
    {
        $this->middleware('auth');
        $this->faq = $faq;
        // $this->agent = $agent;
        $this->locale = $locale;
        $this->image = $images;

        $this->locale->setParent('faqs');
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

        $view = View::make('admin.faqs.index')
                ->with('faq', $this->faq)
                ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate));

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

        $view = View::make('admin.faqs.index')
        ->with('faq', $this->faq)
        ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate))
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(FaqRequest $request)
    {            
    
        $faq = $this->faq->updateOrCreate([
            'id' => request('id')],[
            // 'title' => request('title'),
            // 'description' => request('description'),
            'category_id' => request('category_id'),
            'visible' => request('visible'),
            'active' => 1,
        ]);

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $faq->id);
        }

        if(request('images')){
            
            $images = $this->image->store(request('images'), $faq->id);
        }

        if (request('id')){
            $message = \Lang::get('admin/faqs.faq-update');
        }else{
            $message = \Lang::get('admin/faqs.faq-create');
        }

        $view = View::make('admin.faqs.index')
        ->with('locale', $locale)
        ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate))
        ->with('faq', $faq)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
            'id' => $faq->id,
        ]);
    }

    public function edit(Faq $faq)
    {
        $locale = $this->locale->show($faq->id);

        $view = View::make('admin.faqs.index')
        ->with('locale', $locale)
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function show(Faq $faq){
        
        $locale = $this->locale->show($faq->id);

        $view = View::make('admin.faqs.index')
        ->with('locale', $locale)
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(Faq $faq)
    {
        $faq->active = 0;
        $faq->save();

        $message = Lang::get('admin/faqs.faq-delete');

        $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate($this->paginate))
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }


    public function filter(Request $request, $filters = null){ //Añades el $filters = null

        $filters = json_decode($request->input('filters')); //Aqui convertimos la url en json para poder encontrar los filtros
        
        $query = $this->faq->query();

        if($filters != null){
            /*No se porque pero Carlos ha cambiado la forma de escribir la busqueda de filtros así
            Solo tienes que copiar esto con tus nombres y te deberia funcionar*/
            $query->when($filters->category_id, function ($q, $category_id) {

                if($category_id == 'all'){
                    return $q;
                }
                else {
                    return $q->where('category_id', $category_id);
                }
            });

            $query->when($filters->search, function ($q, $search) {

                if($search == null){
                    return $q;
                }
                else {
                    return $q->where('t_faqs.title', 'like', "%$search%");
                }
            });

            
            $query->when($filters->initial_date, function ($q, $initial_date) {

                if($initial_date == null){
                    return $q;
                }
                else {
                    return $q->whereDate('t_faqs.created_at', '>=', $initial_date);
                    
                }
            });

            $query->when($filters->final_date, function ($q, $final_date) {

                if($final_date == null){
                    return $q;
                }
                else {
                    return $q->whereDate('t_faqs.created_at', '<=', $final_date);
                    
                }
            });

            $query->when($filters->order, function ($q, $order) use ($filters) {

                $q->orderBy($order, $filters->direction);
            });


        }

        //Para que te pagine bien tienes que poner la parte de appends, sino se te quitará el filtro
        $faqs = $query->where('t_faqs.active', 1)->paginate($this->paginate)->appends(['filters' => json_encode($filters)]); 

        $view = View::make('admin.faqs.index')
            ->with('faqs', $faqs)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }
}

/*Ahora mismo lo de filtrar por fechas no me funciona si lo arreglo cambiare esto*/