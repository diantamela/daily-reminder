@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header text-center border-0" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; border-radius: 1rem 1rem 0 0;">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="fas fa-sun fa-2x me-3"></i>
                        <h2 class="mb-0">Today's Daily Reminder</h2>
                    </div>
                    
                    @auth
                    <div class="header-stats mt-3">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="streak-badge d-inline-block">
                                    <i class="fas fa-fire"></i> {{ $streak }} Days
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="days-badge d-inline-block">
                                    <i class="fas fa-calendar-check"></i> {{ $activeDays }} Active
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
                
                <div class="card-body p-5">
                    @if($reminder)
                        <div class="reminder-card text-center">
                            <div class="reminder-icon mb-4">
                                @if($reminder->category == 'motivation')
                                    <i class="fas fa-rocket fa-3x text-primary"></i>
                                @elseif($reminder->category == 'reflection')
                                    <i class="fas fa-brain fa-3x text-success"></i>
                                @elseif($reminder->category == 'self-discipline')
                                    <i class="fas fa-dumbbell fa-3x text-warning"></i>
                                @endif
                            </div>
                            
                            <div class="reminder-message">
                                "{{ $reminder->message }}"
                            </div>
                            
                            @if($reminder->category)
                                <div class="mt-4">
                                    @if($reminder->category == 'motivation')
                                        <span class="badge bg-primary category-badge">
                                            <i class="fas fa-rocket me-1"></i>{{ ucfirst($reminder->category) }}
                                        </span>
                                    @elseif($reminder->category == 'reflection')
                                        <span class="badge bg-success category-badge">
                                            <i class="fas fa-brain me-1"></i>{{ ucfirst($reminder->category) }}
                                        </span>
                                    @elseif($reminder->category == 'self-discipline')
                                        <span class="badge bg-warning category-badge">
                                            <i class="fas fa-dumbbell me-1"></i>{{ ucfirst($reminder->category) }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            @auth
                                <div class="mt-5">
                                    @if(!$hasRead)
                                        <form method="POST" action="{{ route('reminder.mark.read') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="reminder_id" value="{{ $reminder->id }}">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-check-circle me-2"></i>Mark as Read
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-success d-inline-block">
                                            <i class="fas fa-check-circle me-2"></i>Marked as read
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Reflection Form -->
                                <div class="mt-5">
                                    <div class="reflection-section">
                                        <h5 class="mb-4">
                                            <i class="fas fa-pen-fancy me-2 text-success"></i>Reflect on this reminder:
                                        </h5>
                                        <form method="POST" action="{{ route('reminder.save.reflection') }}">
                                            @csrf
                                            <input type="hidden" name="reminder_id" value="{{ $reminder->id }}">
                                            <div class="mb-4">
                                                <textarea 
                                                    class="form-control" 
                                                    name="content" 
                                                    rows="4" 
                                                    placeholder="Share your thoughts about this reminder... What does it mean to you?">{{ $userReflection ? $userReflection->content : '' }}</textarea>
                                                @error('content')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-save me-2"></i>Save Reflection
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info mt-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Sign in</strong> to mark as read and add your personal reflections
                                </div>
                            @endauth
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No reminder available for today</h4>
                            <p class="text-muted">Check back later for your daily inspiration!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Success Messages -->
    @if(session('success'))
        <div class="row justify-content-center mt-4">
            <div class="col-lg-10">
                <div class="alert alert-success text-center" style="backdrop-filter: blur(10px); border: none;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection