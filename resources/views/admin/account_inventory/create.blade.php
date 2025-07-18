@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4>Add Accounts to Inventory (Bulk Upload)</h4>

    <form method="POST" action="{{ route('admin.account_inventory.store') }}">
        @csrf
        <div class="form-group">
            <label>Product</label>
            <select name="product_id" class="form-control" required>
                <option value="">-- Select --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label>Bulk Accounts</label>
            <textarea name="bulk_accounts" class="form-control" rows="8" placeholder="username|password|note (one per line)" required></textarea>
        </div>

        <button class="btn btn-success mt-3">Upload</button>
    </form>
</div>
@endsection
