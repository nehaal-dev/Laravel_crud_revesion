<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer_data=Customer::all();

        return view('index' , compact('customer_data')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'gender' => 'required|string|max:10',
            'payment' => 'required|array' ,
            'country' => 'required|string|min:3|max:20',
            'image' =>'required|file|image|max:2048'
        ]);
        $path=$request->file('image')->store('profile' , 'public');

        Customer::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'payment' => $request->payment,
            'country' => $request->country,            
            'profile'=> $path
        ]);
        return redirect()->route('customers.index')->with('success' , 'Customer data inserted Sucessfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customer $customer)
    {
        //
    }
}
