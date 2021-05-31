<?php

namespace App\Http\Controllers\Products;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use App\Models\Products\ShirtsSizes;
use \Debugbar;

class SizeController extends Controller
{
    protected $size;
    // protected $agent;
    protected $paginate;

    function __construct(ShirtsSizes $size)
    {
        $this->middleware('auth');
        $this->size = $size;
    }

    public function index()
    {
        $view = View::make('admin.layout.sizes')
        ->with('size', $this->size)
        ->with('sizes', $this->size->where('active', 1)->paginate($this->paginate));

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
        foreach (request('size') as $name => $value){
            $size = $this->size->updateOrCreate([
                'id' => request('id')],[
                'size_id' => $value,
                'product_id' => request('product_id'),
                'active' => 1,
            ]);
                }

        if (request('id')){
            $message = \Lang::get('admin/faqs.faq-update');
        }else{
            $message = \Lang::get('admin/faqs.faq-create');
        }

        $view = View::make('admin.layout.sizes')
        ->with('sizes', $this->size->where('active', 1)->paginate($this->paginate))
        ->with('size', $size)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
            'id' => $size->id,
        ]);
    }

}