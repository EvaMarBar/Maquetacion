<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\DB\User;

class UserController extends Controller
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {

        $view = View::make('admin.users.index')
            ->with('user', $this->user)
            ->with('users', $this->user->where('active', 1)->get());   

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

        $view = View::make('admin.users.index')
        ->with('user', $this->user)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(UserRequest $user)
    {            
        $user = $this->user->updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'active' => 1,
        ]);

        $view = View::make('admin.users.index')
        ->with('user', $user)
        ->with('users', $this->user->where('active', 1)->get())
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $user->id,
        ]);
    }

    public function show(User $user)
    {
        $view = View::make('admin.users.index')
        ->with('user', $user)
        ->with('users', $this->user->where('active', 1)->get());   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(User $user)
    {
        $user->active = 0;
        $user->save();

        // $faq->delete();

        $view = View::make('admin.users.index')
            ->with('user', $this->user)
            ->with('users', $this->user->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}
