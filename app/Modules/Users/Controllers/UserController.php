<?php

namespace App\Modules\Users\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Modules\Users\Models\User;
use Illuminate\Http\JsonResponse;
use App\Traits\Attempts;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use Attempts;

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            User::addNewUser($request->validated());
            return response()->json([
                'error' => 0,
                'message' => 'User successfully created'
            ]);
        } catch (\Exception $e) {
            return Helper::addCustomLog('Create User', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            if ($this->hasTooManyAttempts($request))
                return response()->json([
                    'error' => 1,
                    'message' => 'Max failed login attempts reached, please wait 1 minute!'
                ]);
            if (!Auth::attempt($request->validated())) {
                $this->incrementAttempts($request);
                return response()->json([
                    'error' => 1,
                    'message' => 'Credentials not match'
                ]);
            }
            $this->clearAttempts($request);
            return response()->json([
                'error' => 0,
                'message' => auth()->user()->createToken('API Token')->plainTextToken,
            ]);
        } catch (\Exception $e) {
            return Helper::addCustomLog('Login User', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            Auth::guard('web')->logout();
            return response()->json([
                'error' => 0,
                'message' => 'User successfully logged out!'
            ]);
        } catch (\Exception $e) {
            return Helper::addCustomLog('Logout User', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
