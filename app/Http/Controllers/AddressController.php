<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->get();

        return view('pages.addressPage', compact('addresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'full_address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]); 
        $isPrimary = $request->has('is_primary');

        if ($isPrimary) {
            // Set all other addresses to non-primary
            Auth::user()->addresses()->update(['is_primary' => false]);
        }

        $validatedData['is_primary'] = $isPrimary;
        
        Auth::user()->addresses()->create($validatedData);

        return redirect()->route('addresses.index')->with('success', 'Address added successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        abort_if($address->user_id !== Auth::id(), 403);

        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'full_address' => 'required|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]); 
        $isPrimary = $request->has('is_primary');

        if ($isPrimary) {
            // Set all other addresses to non-primary
            Auth::user()->addresses()->update(['is_primary' => false]);
        }

        $validatedData['is_primary'] = $isPrimary;

        $address->update($validatedData);

        return redirect()->route('addresses.index')->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        abort_if($address->user_id !== Auth::id(), 403);

        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully.');
    }
}
