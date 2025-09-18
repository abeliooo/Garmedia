<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.accountPage', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        try {
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
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['success' => 'Password Successfully Changed!']);
        } catch (\Exception $e) {
            Log::error('Password update error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function updateField(Request $request)
    {
        try {
            $fieldName = $request->input('field_name');
            $fieldValue = $request->input('field_value');

            $passwordValidator = Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
            ]);

            if ($passwordValidator->fails()) {
                return response()->json(['errors' => $passwordValidator->errors()], 422);
            }

            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return response()->json(['errors' => ['current_password' => ['Wrong Password.']]], 422);
            }

            $allowedFields = ['name', 'email', 'gender', 'date_of_birth', 'phone_number'];
            if (!in_array($fieldName, $allowedFields)) {
                return response()->json(['errors' => ['field_name' => ['Invalid field specified.']]], 422);
            }

            $rules = ['field_value' => 'required|max:255'];
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
                case 'gender':
                    $rules['field_value'] = 'required|in:male,female,prefer not to say';
                    break;
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = Auth::user();
            $user->{$fieldName} = $fieldValue;
            $user->save();

            return response()->json(['success' => 'Profile updated successfully!']);
        } catch (\Exception $e) {
            Log::error('Field update error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function updatePicture(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            if (!Hash::check($request->current_password, Auth::user()->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['current_password' => ['Wrong Password.']]
                ], 422);
            }

            $user = Auth::user();

            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $path;
                $user->save();

                Log::info('Profile picture updated for user: ' . $user->id . ', new path: ' . $path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Picture update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An unexpected error occurred while uploading the picture.'
            ], 500);
        }
    }

    public function showUserProfile()
    {
        $user = Auth::user();

        $phoneNumber = $user->phone_number;

        return view('profile', ['phone' => $phoneNumber]);
    }
}
