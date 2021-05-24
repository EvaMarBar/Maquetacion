<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Manager;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Models\LocaleLanguage;
use App\Vendor\Locale\Models\LocaleTag;
use \Debugbar;

class LocaleTagController extends Controller
{
    // protected $agent;
    protected $paginate;
    protected $language;
    protected $manager;
    // protected $locale;


    function __construct(LocaleTag $tag, Agent $agent, LocaleLanguage $language, Manager $manager)
    {
        $this->middleware('auth');
        $this->tag = $tag;
        $this->agent = $agent;
        $this->language = $language;
        $this->manager = $manager;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }
    }

    public function index()
    {

        $group = LocaleTag::select('group', 'key')->groupBy('group', 'key')->where('group', 'not like', 'admin/%')->where('group', 'not like', 'front/seo')->where('active', 1)->paginate($this->paginate);

        
        $view = View::make('admin.tags.index')
                ->with('tag', $this->tag)
                ->with('tags',$group);

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
    
        foreach (request('tag') as $rel_anchor => $value){

            $rel_anchor = str_replace(['-', '_'], ".", $rel_anchor); 
            $explode_rel_anchor = explode('.', $rel_anchor);
            $language = end($explode_rel_anchor);

            $tag = $this->tag::updateOrCreate([
                'language' => $language,
                'group' => request('group'),
                'key' => request('key')],[
                'value' => $value,
                'active' => 1
            ]);
        }
        
        $this->manager->exportTranslations(request('group'));   

        $tags = $this->tag
        ->select('group', 'key')
        ->groupBy('group', 'key')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate($this->paginate);  

        // $message = \Lang::get('admin/tags.tag-update');

        $view = View::make('admin.tags.index')
        ->with('tags', $tags)
        ->with('tag', $this->tag)
        ->renderSections(); 

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            // 'message' => $message,
        ]);
    }


    public function show ($group, $key)
    {

        $tags = $this->tag->where('key', $key)->where('group', str_replace('-', '/' , $group))->paginate($this->paginate); 
        $tag = $tags->first();

        $languages = $this->language->get();

        foreach($languages as $language){
            $locale = $tags->filter(function($item) use($language) {
                return $item->language == $language->alias;
            })->first();

            $tag['value.'. $language->alias] = empty($locale->value) ? '': $locale->value; 
        }
        
        $view = View::make('admin.tags.index')
        ->with('tags', $tags)
        ->with('tag', $tag);
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(LocaleTag $tag)
    {
  
    }
    public function importTags()
    {
        $this->manager->importTranslations();  
        // $message =  \Lang::get('admin/tags.tag-import');

        $tags = $this->tag
        ->select('group', 'key')
        ->groupBy('group', 'key')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate($this->paginate);  

        $view = View::make('admin.tags.index')
            ->with('tags', $tags)
            ->with('tag', $this->tag);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                // 'message' => $message,
            ]); 
        }
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