@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h4>Account Inventory</h4>

    <a href="{{ route('admin.account_inventory.create') }}" class="btn btn-primary mb-3">Add New Account</a>

    <form method="GET" class="mb-3">
        <select name="status" onchange="this.form.submit()" class="form-control" style="width: 200px;">
            <option value="">-- Filter by Status --</option>
            @foreach(['Available','Assigned','Delivered','Invalid'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Username</th>
                <th>Status</th>
                <th>Assigned At</th>
                <th>Delivered At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inv)
            <tr>
                <td>{{ $inv->id }}</td>
                <td>{{ $inv->product->name ?? '-' }}</td>
                <td>{{ $inv->username }}</td>
                <td>{{ $inv->status }}</td>
                <td>{{ $inv->assigned_at }}</td>
                <td>{{ $inv->delivered_at }}</td>
                <td>
                    <form action="{{ route('admin.account_inventory.destroy', $inv->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inventories->links() }}
</div>
@endsection
