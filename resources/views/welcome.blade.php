@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full md:w-8/12">
            <div class="card">
                <div class="card-header">
                    <h3>Welcome to Daily Reminder</h3>
                </div>
                
                <div class="card-body text-center">
                    <p class="text-lg text-gray-600">A simple tool to help you grow through daily reminders and reflections.</p>
                    
                    <div class="mt-6">
                        @guest
                            <p>Sign up or log in to start your self-improvement journey!</p>
                            <div class="mt-4 space-x-4">
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                            </div>
                        @else
                            <p>Check out today's reminder and start reflecting!</p>
                            <div class="mt-4">
                                <a href="{{ route('home') }}" class="btn btn-primary">View Today's Reminder</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection