<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthController extends Controller
{
    /**
     * Register New User
     * @param: RegisterRequest $request
     * @return: JSON Response
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "password" => $request->password,
            ]);

            if ($user) {
                return ResponseHelper::success(msg: "User has been registered successfully.", data: $user, status_code: 201);
            }

            return ResponseHelper::error(msg: "Unable to register user. Please try again.", status_code: 400);
        } catch (Exception $e) {
            Log::error("Unable to register user: " . $e->getMessage() . " - Line number: " . $e->getLine());
            return ResponseHelper::error(msg: "Unable to register user. Please try again.", status_code: 500);
        }
    }

    /**
     * Login User
     * @param: LoginRequest $request
     * @return: JSON Response
     */
    public function login(LoginRequest $request)
    {
        try {
            // If Invalid Creds
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ResponseHelper::error(msg: "Invalid credentials.", status_code: 400);
            }

            // Generate API Token
            $user = Auth::user();
            $token = $user->createToken("auth_token_app")->plainTextToken;
            $data = [
                "user" => $user,
                "token" => $token
            ];

            return ResponseHelper::success(msg: "Login successfully.", data: $data, status_code: 200);
        } catch (Exception $e) {
            Log::error("Unable to login: " . $e->getMessage() . " - Line number: " . $e->getLine());
            return ResponseHelper::error(msg: "Unable to login. Please try again.", status_code: 500);
        }
    }

    /**
     * Function: Auth User / Profile Data
     * @param: None
     * @return: JSON Response
     */
    public function userProfile()
    {
        try {
            $user = Auth::user();

            if ($user) {
                return ResponseHelper::success(msg: "Fetch user profile successfully.", data: $user, status_code: 200);
            }

            return ResponseHelper::error(msg: "Unable to fetch user profile. Invalid token.", status_code: 400);
        } catch (Exception $e) {
            Log::error("Unable to fetch user profile: " . $e->getMessage() . " - Line number: " . $e->getLine());
            return ResponseHelper::error(msg: "Unable to fetch user profile. Please try again.", status_code: 500);
        }
    }

    /**
     * Function: User Logout
     * @param: None
     * @return: JSON Response
     */
    public function logout()
    {
        try {
            $user = Auth::user();

            if ($user) {
                $user->currentAccessToken()->delete();

                return ResponseHelper::success(msg: "Logout successfully.", status_code: 200);
            }

            return ResponseHelper::error(msg: "Unable to logout. Invalid token.", status_code: 400);
        } catch (Exception $e) {
            Log::error("Unable to logout due some exception: " . $e->getMessage() . " - Line number: " . $e->getLine());
            return ResponseHelper::error(msg: "Unable to logout due some exception. Please try again.", status_code: 500);
        }
    }
}
