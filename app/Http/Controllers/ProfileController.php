<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if (!$user) {
            return redirect('/home')->with('error', 'User not found');
        }
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'current_password' => 'required|string',
            'new_password' => 'nullable|string|min:8',
        ]);

        if ($request->new_password) {
            $validator->addRules([
                'confirm_password' => 'required|string|min:8|same:new_password',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "validation error",
                    "data" => $validator->errors(),
                ]
            );
        }

        $user = User::where('id', auth()->user()->id)->first();
        if (!$user) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "User not found",
                ]
            );
        }

        if (!password_verify($request->current_password, $user->password)) {
            return response()->json(
                [
                    "status" => "error",
                    "message" => "Current password is incorrect",
                    'data' => [
                        'current_password' => ['Current password is incorrect'],
                    ],
                ]
            );
        }
        
        if ($request->email != $user->email) {
            $email = User::where('email', $request->email)->first();
            if ($email) {
                return response()->json(
                    [
                        "status" => "error",
                        "message" => "Email already used",
                        'data' => [
                            'email' => ['Email already used'],
                        ],
                    ]
                );
            }
        }

        if ($request->email != $user->email) {
            $user->email_verified_at = null;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->new_password) {
            $user->password = bcrypt($request->new_password);
        }
        $user->save();

        return response()->json(
            [
                "status" => "success",
                "message" => "Profile updated",
            ]
        );
    }


}
