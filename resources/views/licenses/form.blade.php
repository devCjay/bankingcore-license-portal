@extends('layouts.app')
@section('title', $mode === 'create' ? 'New License' : 'Edit License')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">{{ $mode === 'create' ? 'New License' : 'Edit License' }}</h1>
            <p class="text-muted mb-0">Bind a customer license to one or more banking app domains.</p>
        </div>
        <a href="{{ route('licenses.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form method="post" action="{{ $mode === 'create' ? route('licenses.store') : route('licenses.update', $license) }}">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">License key</label>
                        <input class="form-control" name="license_key" value="{{ old('license_key', $license->license_key) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            @foreach (['active', 'suspended', 'expired'] as $status)
                                <option value="{{ $status }}" @selected(old('status', $license->status) === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Customer name</label>
                        <input class="form-control" name="customer_name" value="{{ old('customer_name', $license->customer_name) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Customer email</label>
                        <input type="email" class="form-control" name="customer_email" value="{{ old('customer_email', $license->customer_email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Product name</label>
                        <input class="form-control" name="product_name" value="{{ old('product_name', $license->product_name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Max activations</label>
                        <input type="number" class="form-control" name="max_activations" min="1" value="{{ old('max_activations', $license->max_activations) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Expires at</label>
                        <input type="date" class="form-control" name="expires_at" value="{{ old('expires_at', optional($license->expires_at)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Primary domain</label>
                        <input class="form-control" name="domain" value="{{ old('domain', $license->domain) }}" placeholder="example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Allowed domains</label>
                        <textarea class="form-control" name="allowed_domains" rows="3" placeholder="one domain per line">{{ old('allowed_domains', implode("\n", $license->allowed_domains ?: [])) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3">{{ old('notes', $license->notes) }}</textarea>
                    </div>
                </div>

                <button class="btn btn-primary mt-4" type="submit">
                    {{ $mode === 'create' ? 'Create License' : 'Save Changes' }}
                </button>
            </form>
        </div>
    </div>
@endsection
