@extends('layouts.app')
@section('title', 'Licenses')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-1">License Manager</h1>
            <p class="text-muted mb-0">Create, bind, suspend, and validate BankCore installation licenses.</p>
        </div>
        <a href="{{ route('licenses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> New License
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card"><div class="card-body"><span class="text-muted">Total</span><h2 class="fw-bold mt-2">{{ $total }}</h2></div></div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card"><div class="card-body"><span class="text-muted">Active</span><h2 class="fw-bold mt-2 text-success">{{ $active }}</h2></div></div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card"><div class="card-body"><span class="text-muted">Suspended</span><h2 class="fw-bold mt-2 text-danger">{{ $suspended }}</h2></div></div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>License</th>
                            <th>Customer</th>
                            <th>Domain</th>
                            <th>Status</th>
                            <th>Expires</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($licenses as $license)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $license->license_key }}</div>
                                    <small class="text-muted">{{ $license->product_name }}</small>
                                </td>
                                <td>
                                    {{ $license->customer_name ?: 'Unknown' }}<br>
                                    <small class="text-muted">{{ $license->customer_email ?: 'No email' }}</small>
                                </td>
                                <td>
                                    {{ $license->domain ?: 'Auto-bind on first verify' }}<br>
                                    <small class="text-muted">{{ $license->activation_count }}/{{ $license->max_activations }} activations</small>
                                </td>
                                <td><span class="badge badge-{{ $license->status }}">{{ $license->status }}</span></td>
                                <td>{{ $license->expires_at ? $license->expires_at->format('M d, Y') : 'Never' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('licenses.edit', $license) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="post" action="{{ route('licenses.destroy', $license) }}" class="d-inline" onsubmit="return confirm('Delete this license?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-5">No licenses yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $licenses->links() }}
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white"><strong>Recent Verification Attempts</strong></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Status</th><th>License</th><th>Domain</th><th>Message</th><th>Time</th></tr></thead>
                    <tbody>
                        @forelse ($verifications as $log)
                            <tr>
                                <td><span class="badge {{ $log->status === 'valid' ? 'text-bg-success' : 'text-bg-danger' }}">{{ $log->status }}</span></td>
                                <td>{{ $log->license_key }}</td>
                                <td>{{ $log->domain }}</td>
                                <td>{{ $log->message }}</td>
                                <td>{{ $log->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-muted">No verification attempts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
