@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Admin Dashboard</h3>
                    <a href="{{ route('admin.reminders.create') }}" class="btn btn-primary">Add New Reminder</a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Message</th>
                                    <th>Category</th>
                                    <th>Scheduled Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reminders as $reminder)
                                    <tr>
                                        <td>{{ $reminder->id }}</td>
                                        <td>{{ Str::limit($reminder->message, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $reminder->category == 'motivation' ? 'success' : ($reminder->category == 'reflection' ? 'info' : 'warning') }}">
                                                {{ ucfirst($reminder->category) }}
                                            </span>
                                        </td>
                                        <td>{{ $reminder->scheduled_date ? $reminder->scheduled_date->format('M d, Y') : 'Any date' }}</td>
                                        <td>
                                            @if($reminder->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reminders.edit', $reminder->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            
                                            <form action="{{ route('admin.reminders.destroy', $reminder->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this reminder?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No reminders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                        {{ $reminders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection