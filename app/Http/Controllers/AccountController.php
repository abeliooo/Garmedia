<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('account.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(['errors' => ['current_password' => ['Wrong Password']]], 422);
        }
        $user = Auth::user();
        $user->password = $request->password;
        $user->save();

        return response()->json(['success' => 'Password Successfully Changed!']);
    }

    public function updateField(Request $request)
    {
        $fieldName = $request->input('field_name');
        $fieldValue = $request->input('field_value');

        $allowedFields = ['name', 'email', 'gender', 'date_of_birth', 'phone_number'];
        if (!in_array($fieldName, $allowedFields)) {
            return back()->withErrors(['msg' => 'Invalid field specified.']);
        }

        $rules = [
            'field_name' => 'required|string',
            'field_value' => 'required|max:255',
        ];

        switch ($fieldName) {
            case 'email':
                $rules['field_value'] = ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())];
                break;
            case 'phone_number':
                $rules['field_value'] = 'required|string|numeric';
                break;
            case 'date_of_birth':
                $rules['field_value'] = 'required|date';
                break;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $user->{$fieldName} = $fieldValue;
        $user->save();

        return redirect()->route('account')->with('success', 'Profile has been updated successfully!');
    }
}
