<?php

namespace App\Http\Controllers\Products;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use App\Models\Products\ShirtsColours;
use \Debugbar;

class ColourController extends Controller
{
    protected $colour;
    protected $paginate;


    function __construct(ShirtsColours $colour)
    {
        $this->middleware('auth');
        $this->colour = $colour;
    }

    public function index()
    {
        $view = View::make('admin.layout.colours')
        ->with('colour', $this->colour)
        ->with('colours', $this->colour->where('active', 1)->paginate($this->paginate));

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
        foreach (request('colour') as $name => $value){
            $colour = $this->colour->updateOrCreate([
                'id' => request('id')],[
                'colour_id' => $value,
                'product_id' => request('product_id'),
                'active' => 1,
            ]);
                }

        if (request('id')){
            $message = \Lang::get('admin/faqs.faq-update');
        }else{
            $message = \Lang::get('admin/faqs.faq-create');
        }

        $view = View::make('admin.layout.colours')
        ->with('colours', $this->colour->where('active', 1)->paginate($this->paginate))
        ->with('colour', $colour)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
            'id' => $colour->id,
        ]);
    }
}