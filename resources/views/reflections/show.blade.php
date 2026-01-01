@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Reflection Details</h3>
                </div>
                
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Reminder:</h5>
                        <p class="lead">{{ $reflection->reminder->message }}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-{{ $reflection->reminder->category == 'motivation' ? 'success' : ($reflection->reminder->category == 'reflection' ? 'info' : 'warning') }}">
                                {{ ucfirst($reflection->reminder->category) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h5>Your Reflection:</h5>
                        <p>{{ $reflection->content }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">
                            Reflected on: {{ $reflection->created_at->format('F j, Y \a\t g:i A') }}
                        </small>
                    </div>
                    
                    <a href="{{ route('reflections.index') }}" class="btn btn-secondary">Back to Reflections</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection