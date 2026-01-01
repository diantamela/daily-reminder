@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Reminder</h3>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.reminders.update', $reminder->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Reminder Message</label>
                            <textarea 
                                class="form-control @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message" 
                                rows="4" 
                                required>{{ old('message', $reminder->message) }}</textarea>
                            
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="motivation" {{ old('category', $reminder->category) == 'motivation' ? 'selected' : '' }}>Motivation</option>
                                <option value="reflection" {{ old('category', $reminder->category) == 'reflection' ? 'selected' : '' }}>Reflection</option>
                                <option value="self-discipline" {{ old('category', $reminder->category) == 'self-discipline' ? 'selected' : '' }}>Self-Discipline</option>
                            </select>
                            
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="scheduled_date" class="form-label">Scheduled Date (Optional)</label>
                            <input 
                                type="date" 
                                class="form-control @error('scheduled_date') is-invalid @enderror" 
                                id="scheduled_date" 
                                name="scheduled_date" 
                                value="{{ old('scheduled_date', $reminder->scheduled_date) }}">
                            
                            @error('scheduled_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave blank to make this a general reminder that can be randomly selected</div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $reminder->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Reminder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection