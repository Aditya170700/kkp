<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($request->only(['email', 'password']))) {
            return $this->success([
                'token' => JWTAuth::fromUser(auth()->user()),
            ]);
        }

        return $this->failed(422, 'Username / passsword salah');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $otp = $this->generateOTP();
        $role = Role::where('name', 'user')->firstOrFail();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'otp' => $otp,
        ]);

        $user->assignRole($role);

        $this->sendOtp($user->email, $otp);

        auth()->login($user);

        return $this->success([
            'token' => JWTAuth::fromUser($user),
        ]);
    }

    public function otp()
    {
        $otp = $this->generateOTP();
        $user = auth()->user();

        User::where('email', $user->email)
            ->update([
                'otp' => $otp
            ]);

        $this->sendOtp($user->email, $otp);

        auth()->login($user);

        return $this->success($user);
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $user = auth()->user();

        if ($user->otp != $request->otp) {
            return $this->failed(422, 'Kode OTP tidak valid');
        }

        User::where('email', $user->email)
            ->update([
                'email_verified_at' => now(),
            ]);

        return $this->success($user);
    }

    private function generateOTP()
    {
        return substr(str_shuffle('1234567890'), 0, 6);
    }

    private function sendOtp($email, $otp)
    {
        return Http::post('https://script.google.com/macros/s/AKfycbxFNsyMXW8chGL8YhdQE1Q1yBbx5XEsq-BJeNF1a6sKoowaL_9DtcUvE_Pp0r5ootgMhQ/exec', [
            'email' => $email,
            'subject' => 'Kode OTP',
            'message' => "{$otp} adalah kode OTP untuk verifikasi email {$email}",
            'token' => '1dy09eODblmBUCTnIwiY-hbXdzCpZC3jyR4l0ZJgqQqO9L7J3zsZOobdJ',
        ]);
    }
}
