@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>My Reflections</h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($reflections->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Reminder</th>
                                        <th>Reflection</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reflections as $reflection)
                                        <tr>
                                            <td>{{ $reflection->created_at->format('M d, Y') }}</td>
                                            <td>{{ Str::limit($reflection->reminder->message, 50) }}</td>
                                            <td>{{ Str::limit($reflection->content, 100) }}</td>
                                            <td>
                                                <a href="{{ route('reflections.show', $reflection->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            {{ $reflections->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">You haven't saved any reflections yet.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">View Daily Reminder</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection