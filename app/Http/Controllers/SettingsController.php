<?php

namespace App\Http\Controllers;

use Illuminate\support\facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class SettingsController extends Controller
{
    public function settings()
    {
        return view('pages.user_profile.settings');
    }

    /**
     * Updates the user's email.
     *
     * This function handles the email change process for a user. It validates the current and new email,
     * checks if the current email exists in the database, verifies if the new email is unique, and updates
     * the user's email if all validations pass.
     *
     * @param Request $request The incoming request containing the current and new email.
     * @return \Illuminate\Http\JsonResponse The response indicating success or failure of the email update.
     *
     * @throws \Illuminate\Validation\ValidationException If the request parameters fail validation.
     */
    public function changeUserEmail(Request $request)
    {

        $currentEmail = $request->currentEmail;
        $newEmail = $request->newEmail;

        //validate request
        $validator = Validator::make($request->all(), [
            'currentEmail' => 'required|email',
            'newEmail' => 'required|email'
        ]);

        // Check if validation failed
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        //check if current user email exists
        $record = User::where('email', $currentEmail)->first();
        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Current User name!',
            ]);
        }

        //check if the new user email exists
        $checkIfNewEmailExists = User::where('email', $newEmail)->first();
        if ($checkIfNewEmailExists) {
            return response()->json([
                'success' => false,
                'message' => 'New User Email already Exsists!',
            ]);
        }

        //save new email
        $record->email = $newEmail;
        $record->save();
        return response()->json([
            'success' => true,
            'message' => 'Email Updated!'
        ]);
    }

    public function changeUserPassword(Request $request)
    {

        //validate passwords
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|min:8',
            'newPassword' => 'required|min:8|confirmed',
        ]);

        // Check if validation failed
        if ($validator->fails()) {
            //Log::error($validator->errors());
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        //check if current user password is correct
        $currentUser = auth()->user();
        if (!Hash::check($request->currentPassword, $currentUser->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect Current Password!',
            ]);
        }

        //save new password
        Log::info('old user password: ' . $currentUser->password);
        $hashedPassword = Hash::make($request->newPassword);
        Log::info('hashed password: ' . $hashedPassword);
        $currentUser->password = $hashedPassword;
        Log::info('new user password: ' . $currentUser->password);
        $currentUser->save();

        // Log the user out
        auth()->logout();
        // Log the user in with the new password
        if (auth()->attempt(['email' => $currentUser->email, 'password' => $request->newPassword])) {
            Log::info('User logged in successfully with new password');
        } else {
            Log::error('Failed to log in with new password');
        }
        return response()->json([
            'success' => true,
            'message' => 'Password Updated!'
        ]);
    }
}
