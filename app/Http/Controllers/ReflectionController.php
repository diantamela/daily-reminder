<?php

namespace App\Http\Controllers;

use App\Models\Reflection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReflectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $reflections = Reflection::where('user_id', Auth::id())
                               ->with('reminder')
                               ->orderBy('created_at', 'desc')
                               ->paginate(10);
        
        return view('reflections.index', compact('reflections'));
    }
    
    public function show($id)
    {
        $reflection = Reflection::where('id', $id)
                              ->where('user_id', Auth::id())
                              ->with('reminder')
                              ->firstOrFail();
        
        return view('reflections.show', compact('reflection'));
    }
}