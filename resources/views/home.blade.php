@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Today's Daily Reminder</h3>
                    
                    @auth
                    <div class="mt-2">
                        <span class="badge bg-success streak-badge me-2">
                            🏆 Streak: {{ $streak }} days
                        </span>
                        <span class="badge bg-primary days-badge">
                            📅 Active Days: {{ $activeDays }}
                        </span>
                    </div>
                    @endauth
                </div>
                
                <div class="card-body">
                    @if($reminder)
                        <div class="reminder-card text-center">
                            <p class="lead">{{ $reminder->message }}</p>
                            
                            @if($reminder->category)
                                <div class="mt-3">
                                    <span class="badge bg-secondary category-badge">
                                        {{ ucfirst($reminder->category) }}
                                    </span>
                                </div>
                            @endif
                            
                            @auth
                                <div class="mt-4">
                                    @if(!$hasRead)
                                        <form method="POST" action="{{ route('reminder.mark.read') }}">
                                            @csrf
                                            <input type="hidden" name="reminder_id" value="{{ $reminder->id }}">
                                            <button type="submit" class="btn btn-primary">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success">
                                            <i class="fas fa-check-circle"></i> Marked as read
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Reflection Form -->
                                <div class="mt-4">
                                    <h5>Reflect on this reminder:</h5>
                                    <form method="POST" action="{{ route('reminder.save.reflection') }}">
                                        @csrf
                                        <input type="hidden" name="reminder_id" value="{{ $reminder->id }}">
                                        <div class="mb-3">
                                            <textarea 
                                                class="form-control" 
                                                name="content" 
                                                rows="3" 
                                                placeholder="Write your thoughts about this reminder...">{{ $userReflection ? $userReflection->content : '' }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            Save Reflection
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    <small>Sign in to mark as read and add your reflections</small>
                                </div>
                            @endauth
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-muted">No reminder available for today.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection