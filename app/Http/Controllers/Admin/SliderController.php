<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\DB\Slider;
use Debugbar;

class SliderController extends Controller
{
  
    protected $slider;

    function __construct(Slider $slider)
    {
        $this->middleware('auth');
        $this->slider = $slider;
        $this->slider->visible = 1;
    }

    public function index()
    {
   
        $view = View::make('admin.sliders.index')
            ->with('slider', $this->slider)
            ->with('sliders', $this->slider->where('active', 1)->paginate(8));
            

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

        $view = View::make('admin.sliders.index')
        ->with('slider', $this->slider)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(SliderRequest $request)
    {            
        $slider = $this->slider->updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'entity' => request('entity'),
            'visible' => request('visible') == "true" ? 1 : 0,
            'active' => 1 
        ]);

        if (request('id')){
            $message = \Lang::get('admin/sliders.slider-update');
        }else{
            $message = \Lang::get('admin/sliders.slider-create');
        }

        $view = View::make('admin.sliders.index')
        ->with('slider', $slider)
        ->with('sliders', $this->slider->where('active', 1)->paginate(8))
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
            'id' => $slider->id,
        ]);
    }
   
    public function show(Slider $slider)
    {
        $view = View::make('admin.sliders.index')
        ->with('slider', $slider)
        ->with('sliders', $this->slider->where('active', 1)->paginate(8));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view->paginate(8);
    }

    public function destroy(Slider $slider)
    {
        $slider->active = 0;
        $slider->save();

        // $faq->delete();
        $message = \Lang::get('admin/sliders.slider-delete');

        $view = View::make('admin.sliders.index')
            ->with('slider', $this->slider)
            ->with('sliders', $this->slider->where('active', 1)->paginate(8))
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message
        ]);
    }
    public function filter(Request $request){

        $query = $this->slider->query();
        $query->where('t_sliders.active', 1);

        $query->when(request('search'), function ($q, $search) {

            if($search == null){
                return $q;
            }
            else {
                return $q->where('name', 'like', "%$search%");
            }
        });

        $query->when(request('initial-date'), function ($q, $initialDate) {

            if($initialDate == null){
                return $q;
            }
            else {
                return $q->whereDate('created_at', '>=' , $initialDate);
                
            }
        });
        
        $query->when(request('final-date'), function ($q, $finalDate) {

            if($finalDate == null){
                return $q;
            }
            else {
                return $q->whereDate('created_at', '<=' , $finalDate);
                
            }
        });

        $query->when(request('order'), function ($q, $order) use ($request){

            $q->orderBy($order, $request->direction);
        });
               
        $sliders = $query->where('active', 1)->paginate(8);

        $view = View::make('admin.sliders.index')
            ->with('slider', $this->slider)
            ->with('sliders', $sliders)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    // public function order($column){

    //     $faqs = $this->faq->where('active', 1)->orderBy($column, 'asc')->get();
    
    //     $view = View::make('admin.faqs.index')
    //         ->with('faqs', $faqs)
    //         ->renderSections();

    //     return response()->json([
    //         'table' => $view['table'],
    //     ]);
    // }

}
