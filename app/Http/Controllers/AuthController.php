<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forgotPassword', 'checkAuthenticationCode', 'resetPassword']]);
        $this->authService = new AuthService;
    }


    # Đăng ký người dùng
    public function register()
    {
        try {
            $validatedData = request()->validate([
                'fullName' => 'required|string|min:2',
                'phoneNumber' => 'required|string|unique:users,phone|regex:/^0\d{9}$/',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = $this->authService->handleRegister($validatedData);

            return response()->json(['message' => 'Sign Up Success', 'user' => $user], 201);
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Đăng nhập
    public function login()
    {
        try {
            $credentials = request()->validate([
                'userName' => 'required',
                'password' => 'required',
            ]);

            $token = $this->authService->handleLogin($credentials);

            $refreshToken = $this->authService->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Quên mật khẩu
    public function forgotPassword()
    {
        try {
            $validatedData = request()->validate([
                'email' => 'required|email',
            ]);

            $this->authService->handleForgotPassword($validatedData['email']);

            return response()->json(['message' => 'Reset link has been sent to your email.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Kiểm tra mã xác thực
    public function checkAuthenticationCode()
    {
        try {
            $validatedData = request()->validate([
                'confirmCode' => 'required|string',
                'email' => 'required|string|email',
            ]);

            $this->authService->handleCheckAuthenticationCode($validatedData);

            return response()->json(['message' => 'Token is valid.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Đặt lại mật khẩu
    public function resetPassword()
    {
        try {
            $validatedData = request()->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            $this->authService->handleResetPassword($validatedData);

            return response()->json(['message' => 'Password has been reset.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Đăng xuất
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Signed out successfully']);
    }


    # Hồ sơ người dùng
    public function profile()
    {
        try {
            return response()->json(auth('api')->user());
        } catch (JWTException $e) {

            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    # Làm mới token
    public function refresh()
    {
        $refreshToken = request()->refresh_token;

        try {
            $decode = JWTAuth::getJWTProvider()->decode($refreshToken);

            $user = User::find($decode['user_id']);

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            JWTAuth::invalidate(JWTAuth::getToken()); // Vô hiệu hoá token cũ

            // auth('api')->invalidate();  // Vô hiệu hoá token cũ

            $token = auth('api')->login($user);

            $refreshToken = $this->authService->createRefreshToken();

            return $this->respondWithToken($token, $refreshToken);
        } catch (JWTException $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    # Trả token về view
    protected function respondWithToken($token,  $refreshToken)
    {
        return response()->json([
            'role' => auth('api')->user()->role->name,
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
}
