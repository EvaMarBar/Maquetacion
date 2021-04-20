<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\DB\Faq;

class FaqController extends Controller
{
  
    protected $faq;

    function __construct(Faq $faq)
    {
        $this->middleware('auth');
        $this->faq = $faq;
    }

    public function index()
    {

        $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->get());   

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
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(FaqRequest $request)
    {            
        $faq = $this->faq->updateOrCreate([
            'id' => request('id')],[
            'title' => request('title'),
            'description' => request('description'),
            'active' => 1,
            'category_id' => request('category_id'),
        ]);

        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->get())
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $faq->id,
        ]);
    }

    public function show(Faq $faq)
    {
        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->get());   
        
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

        // $faq->delete();

        $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
    public function filter(Request $request){

        $query = $this->faq->query();

        $query->when(request('category_id'), function ($q, $category_id) {

            if($category_id == 'all'){
                return $q;
            }
            else {
                return $q->where('category_id', $category_id);
            }
        });

        $query->when(request('search'), function ($q, $search) {

            if($search == null){
                return $q;
            }
            else {
                return $q->where('title', 'like', "%$search%");
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

               
        $faqs = $query->where('active', 1)->get();

        $view = View::make('admin.faqs.index')
            ->with('faqs', $faqs)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    // public function order (Faq $faq){

    //     $this->faq = Faq::where('active', 1)->orderBy('title', 'asc')->get();
    
    //     $view = View::make('admin.faqs.index')
    //         ->with('faq', $this->faq)
    //         ->renderSections();

    //     return response()->json([
    //         'table' => $view['table'],
    //     ]);
    // }

}
