<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10);
        return response()->json($customers);
    }

    public function create()
    {
        return response()->json(['message' => 'Create a new customer']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'link' => 'required',
        ]);
        Customer::create($request->all());
        return response()->json(['message' => 'Customer created successfully.']);
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update($request->all());
        return response()->json(['message' => 'Customer updated successfully.']);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully.']);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $customers = Customer::where('name', 'like', '%' . $search . '%')->paginate(10);
        return response()->json($customers);
    }
}

