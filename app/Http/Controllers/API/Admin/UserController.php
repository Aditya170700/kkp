<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $result = User::latest()
            ->role('user')
            ->paginate(10)
            ->withQueryString();

        return $this->success($result);
    }

    public function verify(User $user)
    {
        $user->update([
            'is_verified' => true,
        ]);

        return $this->success($user);
    }
}
