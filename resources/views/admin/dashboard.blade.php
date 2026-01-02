@extends('layouts.admin-sidebar')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stats-card p-4 text-center">
            <i class="fas fa-bell fa-3x mb-3 text-warning"></i>
            <h3 class="mb-2">{{ $reminders->total() }}</h3>
            <p class="mb-0 opacity-75">Total Reminders</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card p-4 text-center">
            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
            <h3 class="mb-2">{{ $reminders->where('is_active', true)->count() }}</h3>
            <p class="mb-0 opacity-75">Active Reminders</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card p-4 text-center">
            <i class="fas fa-clock fa-3x mb-3 text-info"></i>
            <h3 class="mb-2">{{ $reminders->where('is_active', false)->count() }}</h3>
            <p class="mb-0 opacity-75">Inactive Reminders</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card p-4 text-center">
            <i class="fas fa-calendar-day fa-3x mb-3 text-primary"></i>
            <h3 class="mb-2">{{ $reminders->whereNotNull('scheduled_date')->count() }}</h3>
            <p class="mb-0 opacity-75">Scheduled Today</p>
        </div>
    </div>
</div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="admin-stats-card p-4 text-center">
                <i class="fas fa-bell fa-2x mb-3 text-warning"></i>
                <h4 class="mb-1">{{ $reminders->total() }}</h4>
                <p class="mb-0 opacity-75">Total Reminders</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="admin-stats-card p-4 text-center">
                <i class="fas fa-check-circle fa-2x mb-3 text-success"></i>
                <h4 class="mb-1">{{ $reminders->where('is_active', true)->count() }}</h4>
                <p class="mb-0 opacity-75">Active Reminders</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="admin-stats-card p-4 text-center">
                <i class="fas fa-clock fa-2x mb-3 text-info"></i>
                <h4 class="mb-1">{{ $reminders->where('is_active', false)->count() }}</h4>
                <p class="mb-0 opacity-75">Inactive Reminders</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="admin-stats-card p-4 text-center">
                <i class="fas fa-calendar-day fa-2x mb-3 text-primary"></i>
                <h4 class="mb-1">{{ $reminders->whereNotNull('scheduled_date')->count() }}</h4>
                <p class="mb-0 opacity-75">Scheduled Today</p>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-success border-0" style="background: linear-gradient(45deg, #28a745, #20c997); color: white; border-radius: 0.75rem;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    
    @if(session('info'))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info border-0" style="background: linear-gradient(45deg, #1e3c72, #2a5298); color: white; border-radius: 0.75rem;">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                </div>
            </div>
        </div>
    @endif
                    
                    <div class="admin-card">
                        <div class="admin-card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-list me-2"></i>Reminders Management
                                </h4>
                                <a href="{{ route('admin.reminders.create') }}" class="btn btn-admin btn-sm">
                                    <i class="fas fa-plus me-1"></i>Create New
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @if($reminders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table admin-table mb-0">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                                <th><i class="fas fa-comment me-1"></i>Message</th>
                                                <th><i class="fas fa-tags me-1"></i>Category</th>
                                                <th><i class="fas fa-calendar me-1"></i>Scheduled Date</th>
                                                <th><i class="fas fa-toggle-on me-1"></i>Status</th>
                                                <th><i class="fas fa-cogs me-1"></i>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reminders as $reminder)
                                                <tr>
                                                    <td><strong>#{{ $reminder->id }}</strong></td>
                                                    <td>
                                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $reminder->message }}">
                                                            {{ Str::limit($reminder->message, 50) }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($reminder->category == 'motivation')
                                                            <span class="admin-badge bg-success">
                                                                <i class="fas fa-rocket me-1"></i>{{ ucfirst($reminder->category) }}
                                                            </span>
                                                        @elseif($reminder->category == 'reflection')
                                                            <span class="admin-badge bg-info">
                                                                <i class="fas fa-brain me-1"></i>{{ ucfirst($reminder->category) }}
                                                            </span>
                                                        @elseif($reminder->category == 'self-discipline')
                                                            <span class="admin-badge bg-warning">
                                                                <i class="fas fa-dumbbell me-1"></i>{{ ucfirst($reminder->category) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($reminder->scheduled_date)
                                                            <i class="fas fa-calendar-check text-success me-1"></i>
                                                            {{ $reminder->scheduled_date->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">
                                                                <i class="fas fa-infinity me-1"></i>Any date
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($reminder->is_active)
                                                            <span class="admin-badge bg-success">
                                                                <i class="fas fa-check me-1"></i>Active
                                                            </span>
                                                        @else
                                                            <span class="admin-badge bg-secondary">
                                                                <i class="fas fa-pause me-1"></i>Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.reminders.edit', $reminder->id) }}" class="admin-btn-primary btn btn-sm">
                                                                <i class="fas fa-edit me-1"></i>Edit
                                                            </a>
                                                            
                                                            <form action="{{ route('admin.reminders.destroy', $reminder->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="admin-btn-danger btn btn-sm" onclick="return confirm('Are you sure you want to delete this reminder?')">
                                                                    <i class="fas fa-trash me-1"></i>Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="p-4 border-top">
                                    {{ $reminders->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No reminders found</h5>
                                    <p class="text-muted">Start by creating your first reminder</p>
                                    <a href="{{ route('admin.reminders.create') }}" class="admin-btn-primary btn">
                                        <i class="fas fa-plus me-2"></i>Create Reminder
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection