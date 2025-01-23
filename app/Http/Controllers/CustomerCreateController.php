<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerCreateController extends Controller
{
    public function customerRegistration()
    {
        $customers = Customer::all();
        return view('customer.customer-registration', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:customers,email',
        ]);

        Customer::create($request->all());
        return redirect()->route('customer.customer-registration')->with('success', 'Customer added successfully!');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id); // Fetch customer by ID
        return view('customer.edit', compact('customer')); // Pass customer data to the view
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'email' => 'required|email|max:255',
    ]);

    $customer = Customer::findOrFail($id);
    $customer->update($request->all());

    return redirect()->back()->with('success', 'Customer updated successfully!');
}


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id); // Fetch customer by ID
        $customer->delete(); // Delete the customer

        return redirect()->route('customer.customer-registration')->with('success', 'Customer deleted successfully.');
    }


}