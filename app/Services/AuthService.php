<?php

namespace App\Services;

use App\Mail\AuthenticationCode;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    # Xử lý đăng ký
    public function handleRegister($data)
    {
        try {
            $user = User::create([
                'full_name' => $data['fullName'],
                'phone' => $data['phoneNumber'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => Role::where('name', 'Client')->first()->id,
            ]);

            return $user;
        } catch (QueryException $e) {

            throw new \Exception('Error creating user: ' . $e->getMessage(), 500);
        }
    }


    # Xử lý đăng nhập
    public function handleLogin($credentials)
    {
        try {
            // Đăng nhập bằng E-mail
            if (!$token = auth('api')->attempt(['email' => $credentials['userName'], 'password' => $credentials['password']])) {

                // Đăng nhập bằng số điện thoại
                if (!$token = auth('api')->attempt(['phone' => $credentials['userName'], 'password' => $credentials['password']])) {

                    // Trả về lỗi nếu đăng nhập không thành công
                    throw new \Exception('Invalid email or username and password.', 401);
                }
            }

            return $token;
        } catch (QueryException $e) {

            throw new \Exception('Error during login: ' . $e->getMessage(), 500);
        }
    }


    # Xử lý quên mật khẩu
    public function handleForgotPassword($email)
    {
        try {
            $user = User::where('email', $email)->first();

            DB::table('password_reset_tokens')->where('email', $email)->delete();

            $token = str_pad(rand(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);

            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]); // tạo token

            Mail::to($user->email)->send(new AuthenticationCode($token)); // gửi token về email
        } catch (\Exception $e) {

            throw new \Exception('Unable to send reset link: ' . $e->getMessage(), 500);
        }
    }


    # Xử lý quên mật khẩu
    public function handleCheckAuthenticationCode($data)
    {
        try {
            $email = $data['email'];
            $token = $data['confirmCode'];

            $tokenRecord = DB::table('password_reset_tokens')->where('email', $email)->first();

            if ($tokenRecord && Hash::check($token, $tokenRecord->token) && Carbon::parse($tokenRecord->created_at)->addMinutes(config('auth.passwords.users.expire'))->isFuture()) {

                DB::table('password_reset_tokens')->where('email', $email)->update(['is_authenticated' => true]);
            } else {

                throw new \Exception('Token is invalid or expired', 422);
            }
        } catch (\Exception $e) {

            throw new \Exception($e->getMessage(), 500);
        }
    }


    # Xử lý đặt lại mật khẩu
    public function handleResetPassword($data)
    {
        try {
            $tokenRecord = DB::table('password_reset_tokens')->where('email', $data['email'])->first();

            if ($tokenRecord->is_authenticated == true) {

                $user = User::where('email', $data['email'])->first();

                $user->password = Hash::make($data['password']);

                $user->save();

                DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
            } else {

                throw new \Exception('Token not authenticated or expired', 422);
            }
        } catch (\Exception $e) {

            throw new \Exception('Unable to reset password: ' . $e->getMessage(), 500);
        }
    }


    # Tạo refresh token
    public function createRefreshToken()
    {
        $data = [
            'user_id' => auth('api')->user()->id,
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];

        return JWTAuth::getJWTProvider()->encode($data);
    }
}
