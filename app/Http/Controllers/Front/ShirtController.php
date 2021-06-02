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

            return $view;

        }else{
            return response()->view('errors.404', [], 404);
        }
    }
}
