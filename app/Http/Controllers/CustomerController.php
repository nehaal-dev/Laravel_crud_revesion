<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index()
    {
        $customer_data = Customer::all();

        return view('customers.index', compact('customer_data'));
    }


    public function create()
    {
        return view('customers.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'gender' => 'required|string|max:10',
            'payment' => 'required|array',
            'country' => 'required|string|min:3|max:20',
            'image' => 'required|file|image|max:2048'
        ]);
        $path = $request->file('image')->store('profile', 'public');

        Customer::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'payment' => $request->payment,
            'country' => $request->country,
            'profile' => $path
        ]);
        return redirect()->route('customers.index')->with('success', 'Customer data inserted Sucessfully');
    }


    public function show(customer $customer)
    {       
        return view('customers.show' , compact('customer'));
    }

    public function edit(customer $customer)
    {

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:250',
            'gender' => 'required|string',
            'payment' => 'required|array',
            'country' => 'required|string',
            'image' => 'nullable|file|image|max:2048'
        ]);


        $data = [
            'name' => $request->name,
            'gender' => $request->gender,
            'payment' => $request->payment,
            'country' => $request->country,
        ];

        if ($request->hasFile('image')) {

            //delete old image
            Storage::disk('public')->delete($customer->profile);
            //save new one
            $data['profile'] = $request->file('image')->store('profile', 'public');
        }

        $customer->update($data);


        return redirect()->route('customers.index')->with('success', 'Customer Data updated successfully');
    }


    public function destroy(Customer $customer)
    {
        //first delete image from   storage 
        Storage::disk('public')->delete($customer->profile);
        //then after delete specic data 
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted ');
    }

    //Manual method for delete with passing id 
    // public function destroy($id){

    //     $customer=Customer::find($id);
    //     if(!$customer){
    //         abort(404, 'customer not found for delete');
    //     }
    //     Storage::disk('public')->delete($customer->profile);
    //     $customer->delete();

    //     return redirect()->route('customers.index')->with('success' , 'Customer Data Deleted successfully');
    // }





}
