<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DB\ShirtsCategory;

class ShirtsCategoryController extends Controller
{
    protected $shirt_category;

    function __construct(ShirtsCategory $shirt_category)
    {
        $this->middleware('auth');
        $this->shirt_category = $shirt_category;
    }

    public function index()
    {

        $view = View::make('admin.shirts_category.index')
            ->with('shirt_category', $this->shirt_category)
            ->with('shirts_category', $this->shirt_category->where('active', 1)->get());   

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

        $view = View::make('admin.shirts_category.index')
        ->with('shirt_category', $this->shirt_category)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(ShirtsCategoryRequest $request)
    {            
        $shirt_category = ShirtsCategory::updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'active' => 1,
        ]);

        $view = View::make('admin.shirts_category.index')
            ->with('shirt_category', $shirt_category)
            ->with('shirts_category', $this->shirt_category->where('active', 1)->get())   
            ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $shirt_category->id,
        ]);
    }

    public function show(ShirtsCategory $shirt_category)
    {
        $view = View::make('admin.shirts_category.index')
        ->with('shirt_category', $shirt_category)
        ->with('shirts_category', $this->shirt_category->where('active', 1)->get());   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(ShirtsCategory $shirt_category)
    {
        $shirt_category->active = 0;
        $shirt_category->save();

        // $faq->delete();

        $view = View::make('admin.shirts_category.index')
            ->with('shirt_category', $this->shirt_category)
            ->with('shirts_category', $this->shirt_category->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}
