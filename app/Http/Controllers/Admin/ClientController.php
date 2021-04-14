<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\DB\Client;

class ClientController extends Controller
{
  
    protected $client;

    function __construct(Client $client)
    {
        $this->middleware('auth');
        $this->client = $client;
    }

    public function index()
    {

        $view = View::make('admin.clients.index')
            ->with('client', $this->client)
            ->with('clients', $this->client->where('active', 1)->get());   

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

        $view = View::make('admin.clients.index')
        ->with('client', $this->client)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(ClientRequest $request)
    {            
        $client = $this->client->updateOrCreate([
            'id' => request('id')],[
            'client_name' => request('client_name'),
            'surname' => request('surname'),
            'address' => request('address'),
            'postal_code' => request('postal_code'),
            'city' => request('city'),
            'country' => request('country'),
            'email' => request('email'),
            'telephone' => request('telephone'),
            'order_id' => request('order_id'),
            'date_ordered' => request('date_ordered'),
            'date_sended' => request('date_sended'),
            'payment' => request('payment'),
            'active' => 1,
           
        ]);

        $view = View::make('admin.clients.index')
        ->with('client', $client)
        ->with('clients', $this->client->where('active', 1)->get())
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $client->id,
        ]);
    }

    public function show(Client $client)
    {
        $view = View::make('admin.clients.index')
        ->with('client', $client)
        ->with('clients', $this->client->where('active', 1)->get());   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(Client $client)
    {
        $client->active = 0;
        $client->save();

        // $faq->delete();

        $view = View::make('admin.clients.index')
            ->with('client', $this->client)
            ->with('clients', $this->client->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}
