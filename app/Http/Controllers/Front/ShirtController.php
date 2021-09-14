<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\Products\Shirt;
use Debugbar;

class ShirtController extends Controller
{
    protected $agent;
    protected $shirt;
    protected $locale_slug_seo;

    function __construct(Agent $agent, Shirt $shirt, LocaleSlugSeo $locale_slug_seo)
    {
        $this->agent = $agent;
        $this->shirt = $shirt;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('shirts');      
    }

    public function index()
    {        

        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());

        if($this->agent->isDesktop()){

            $shirts = $this->shirt
                    ->with('image_featured_desktop')
                    ->where('active', 1)
                    ->get();
        }
        
        elseif($this->agent->isMobile()){
            $shirts = $this->shirt
                    ->with('image_featured_mobile')
                    ->where('active', 1)
                    ->get();
        }

        $shirts = $shirts->each(function($shirt){  
            
            $shirt['locale'] = $shirt->locale->pluck('value','tag');
            
            return $shirt;
        });
        
        $view = View::make('front.pages.shirts.index')
                ->with('shirts', $shirts) 
                ->with('seo', $seo );

        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'view' => $sections['content'],
            ]); 
        }
        
        return $view;
    }

    public function show($slug)
    {      
        $seo = $this->locale_slug_seo->getIdByLanguage($slug);

        if(isset($seo->key)){

            if($this->agent->isDesktop()){
                $shirt = $this->shirt
                    ->with('image_featured_desktop')
                    ->with('image_grid_desktop')
                    ->where('active', 1)
                    ->find($seo->key);
            }
            
            elseif($this->agent->isMobile()){
                $shirt = $this->shirt
                    ->with('image_featured_mobile')
                    ->with('image_grid_mobile')
                    ->where('active', 1)
                    ->find($seo->key);
            }

        $shirt['locale'] = $shirt->locale->pluck('value','tag');
        
        $view = View::make('front.pages.shirts.single')->with('shirt', $shirt);
    
        if(request()->ajax()) {
    
            $sections = $view->renderSections(); 

            return response()->json([
                'view' => $sections['content'],
            ]); 

        }

        return $view;
       

        }else{
            return response()->view('errors.404', [], 404);
        }
    }
    public function filter(Request $request, $filters = null){

        $filters = json_decode($request->input('filters')); 
        
        $query = $this->shirt->query();

        if($filters != null){
           
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
                    return $q->where('t_shirts.title', 'like', "%$search%");
                }
            });


            $query->when($filters->order, function ($q, $order) use ($filters) {

                $q->orderBy($order, $filters->direction);
            });


        }

        $shirts = $query->where('t_shirts.active', 1)->paginate($this->paginate)->appends(['filters' => json_encode($filters)]); 

        $view = View::make('front.pages.shirts.index')
            ->with('shirts', $shirts)
            ->renderSections();

        return response()->json([
            'product' => $view['content'],
        ]);
    }

}
