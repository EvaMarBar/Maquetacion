<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqCategoryRequest;
use App\Models\DB\FaqCategory;

class FaqCategoryController extends Controller
{
    protected $faq_category;

    function __construct(FaqCategory $faq_category)
    {
        $this->middleware('auth');
        $this->faq_category = $faq_category;
    }

    public function index()
    {

        $view = View::make('admin.faqs_category.index')
            ->with('faq_category', $this->faq_category)
            ->with('faqs_category', $this->faq_category->where('active', 1)->get());   

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

        $view = View::make('admin.faqs_category.index')
        ->with('faq_category', $this->faq_category)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(FaqCategoryRequest $request)
    {            
        $faq_category = FaqCategory::updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'active' => 1,
        ]);

        $view = View::make('admin.faqs_category.index')
            ->with('faq_category', $faq_category)
            ->with('faqs_category', $this->faq_category->where('active', 1)->get())   
            ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $faq_category->id,
        ]);
    }

    public function show(FaqCategory $faq_category)
    {
        $view = View::make('admin.faqs_category.index')
        ->with('faq_category', $faq_category)
        ->with('faqs_category', $this->faq_category->where('active', 1)->get());   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(FaqCategory $faq_category)
    {
        $faq_category->active = 0;
        $faq_category->save();

        // $faq->delete();

        $view = View::make('admin.faqs_category.index')
            ->with('faq_category', $this->faq_category)
            ->with('faqs_category', $this->faq_category->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}
