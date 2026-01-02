@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full lg:w-10/12">
            <div class="card">
                <div class="card-header text-center border-0 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-t-2xl">
                    <div class="flex items-center justify-center mb-3">
                        <i class="fas fa-sun fa-2x mr-3"></i>
                        <h2 class="mb-0">Today's Daily Reminder</h2>
                    </div>
                    
                    @auth
                    <div class="header-stats mt-3">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div>
                                <div class="streak-badge inline-flex items-center">
                                    <i class="fas fa-fire mr-1"></i> {{ $streak }} Days
                                </div>
                            </div>
                            <div>
                                <div class="days-badge inline-flex items-center">
                                    <i class="fas fa-calendar-check mr-1"></i> {{ $activeDays }} Active
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
                
                <div class="card-body p-8">
                    @if($reminder)
                        <div class="reminder-card text-center">
                            <div class="reminder-icon mb-4">
                                @if($reminder->category == 'motivation')
                                    <i class="fas fa-rocket fa-3x text-blue-500"></i>
                                @elseif($reminder->category == 'reflection')
                                    <i class="fas fa-brain fa-3x text-green-500"></i>
                                @elseif($reminder->category == 'self-discipline')
                                    <i class="fas fa-dumbbell fa-3x text-yellow-500"></i>
                                @endif
                            </div>
                            
                            <div class="reminder-message">
                                "{{ $reminder->message }}"
                            </div>
                            
                            @if($reminder->category)
                                <div class="mt-4">
                                    @if($reminder->category == 'motivation')
                                        <span class="badge bg-blue-500 text-white category-badge">
                                            <i class="fas fa-rocket mr-1"></i>{{ ucfirst($reminder->category) }}
                                        </span>
                                    @elseif($reminder->category == 'reflection')
                                        <span class="badge bg-green-500 text-white category-badge">
                                            <i class="fas fa-brain mr-1"></i>{{ ucfirst($reminder->category) }}
                                        </span>
                                    @elseif($reminder->category == 'self-discipline')
                                        <span class="badge bg-yellow-500 text-white category-badge">
                                            <i class="fas fa-dumbbell mr-1"></i>{{ ucfirst($reminder->category) }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            @auth
                                <div class="mt-5">
                                    @if(!$hasRead)
                                        <form method="POST" action="{{ route('reminder.mark.read') }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="reminder_id" value="{{ $reminder->id }}">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-check-circle mr-2"></i>Mark as Read
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-success inline-block">
                                            <i class="fas fa-check-circle mr-2"></i>Marked as read
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Reflection Form -->
                                <div class="mt-5">
                                    <div class="reflection-section">
                                        <h5 class="mb-4">
                                            <i class="fas fa-pen-fancy mr-2 text-green-500"></i>Reflect on this reminder:
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
                                                    <div class="text-red-500 mt-2">{{ $message }}</div>
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
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Sign in</strong> to mark as read and add your personal reflections
                                </div>
                            @endauth
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-inbox fa-3x text-gray-400 mb-3"></i>
                            <h4 class="text-gray-500">No reminder available for today</h4>
                            <p class="text-gray-500">Check back later for your daily inspiration!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Success Messages -->
    @if(session('success'))
        <div class="flex justify-center mt-4">
            <div class="w-full lg:w-10/12">
                <div class="alert alert-success text-center backdrop-blur-sm border-0">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection