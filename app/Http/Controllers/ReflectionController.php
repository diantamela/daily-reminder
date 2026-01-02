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
        $this->middleware(function ($request, $next) {
            // Check if user is admin - redirect them away from reflections page
            if (Auth::check() && Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard')->with('info', 'Admins should use the Admin Dashboard to manage reminders.');
            }
            return $next($request);
        });
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