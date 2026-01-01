<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        // Only allow admin users - in a real app, you'd check for admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        $reminders = Reminder::orderBy('scheduled_date', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);
        
        return view('admin.dashboard', compact('reminders'));
    }
    
    public function create()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        return view('admin.create');
    }
    
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'message' => 'required|string|max:500',
            'category' => 'required|in:motivation,reflection,self-discipline',
            'scheduled_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        
        Reminder::create([
            'message' => $request->message,
            'category' => $request->category,
            'scheduled_date' => $request->scheduled_date,
            'is_active' => $request->filled('is_active'),
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Reminder created successfully!');
    }
    
    public function edit($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        $reminder = Reminder::findOrFail($id);
        return view('admin.edit', compact('reminder'));
    }
    
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'message' => 'required|string|max:500',
            'category' => 'required|in:motivation,reflection,self-discipline',
            'scheduled_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);
        
        $reminder = Reminder::findOrFail($id);
        $reminder->update([
            'message' => $request->message,
            'category' => $request->category,
            'scheduled_date' => $request->scheduled_date,
            'is_active' => $request->filled('is_active'),
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Reminder updated successfully!');
    }
    
    public function destroy($id)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }
        
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Reminder deleted successfully!');
    }
}