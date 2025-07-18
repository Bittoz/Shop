<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountInventory;
use App\Models\Product;

class AccountInventoryController extends Controller
{
    public function index(Request $request)
    {
        $inventories = AccountInventory::with('product')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.account_inventory.index', compact('inventories'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.account_inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'bulk_accounts' => 'required|string',
        ]);

        $rows = explode("\n", trim($request->bulk_accounts));
        foreach ($rows as $line) {
            [$username, $password, $note] = array_pad(explode('|', trim($line), 3), 3, null);

            if ($username && $password) {
                AccountInventory::create([
                    'product_id' => $request->product_id,
                    'username' => $username,
                    'password' => $password,
                    'note' => $note,
                    'status' => 'Available',
                ]);
            }
        }

        return redirect()->route('admin.account_inventory.index')->with('success', 'Accounts uploaded.');
    }

    public function destroy(AccountInventory $accountInventory)
    {
        $accountInventory->delete();
        return back()->with('success', 'Account deleted.');
    }
}
