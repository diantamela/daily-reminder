@extends('layouts.admin-sidebar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Create New Reminder
                </h3>
            </div>
            
            <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.reminders.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="message" class="form-label fw-bold">
                                    <i class="fas fa-comment me-2 text-primary"></i>Reminder Message
                                </label>
                                <textarea 
                                    class="admin-form-control @error('message') is-invalid @enderror" 
                                    id="message" 
                                    name="message" 
                                    rows="5" 
                                    placeholder="Enter your motivational message or reminder..."
                                    required>{{ old('message') }}</textarea>
                                
                                @error('message')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="category" class="form-label fw-bold">
                                    <i class="fas fa-tags me-2 text-success"></i>Category
                                </label>
                                <select class="admin-form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                    <option value="">Select a category</option>
                                    <option value="motivation" {{ old('category') == 'motivation' ? 'selected' : '' }}>
                                        <i class="fas fa-rocket me-1"></i>Motivation
                                    </option>
                                    <option value="reflection" {{ old('category') == 'reflection' ? 'selected' : '' }}>
                                        <i class="fas fa-brain me-1"></i>Reflection
                                    </option>
                                    <option value="self-discipline" {{ old('category') == 'self-discipline' ? 'selected' : '' }}>
                                        <i class="fas fa-dumbbell me-1"></i>Self-Discipline
                                    </option>
                                </select>
                                
                                @error('category')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="scheduled_date" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-info"></i>Scheduled Date (Optional)
                                </label>
                                <input 
                                    type="date" 
                                    class="admin-form-control @error('scheduled_date') is-invalid @enderror" 
                                    id="scheduled_date" 
                                    name="scheduled_date" 
                                    value="{{ old('scheduled_date') }}">
                                
                                @error('scheduled_date')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i>Leave blank for general reminders
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label fw-bold" for="is_active">
                                        <i class="fas fa-toggle-on me-2 text-success"></i>Active Reminder
                                    </label>
                                    <div class="form-text">
                                        Active reminders will be shown to users
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                    </a>
                                    <button type="submit" class="admin-btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Reminder
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection