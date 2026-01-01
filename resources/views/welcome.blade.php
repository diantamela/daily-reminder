@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Welcome to Daily Reminder</h3>
                </div>
                
                <div class="card-body text-center">
                    <p class="lead">A simple tool to help you grow through daily reminders and reflections.</p>
                    
                    <div class="mt-4">
                        @guest
                            <p>Sign up or log in to start your self-improvement journey!</p>
                            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                        @else
                            <p>Check out today's reminder and start reflecting!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">View Today's Reminder</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection