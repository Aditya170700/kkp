<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Ship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipController extends Controller
{
    public function index()
    {
        $result = Ship::latest()
            ->paginate(10)
            ->withQueryString();

        return $this->success($result);
    }

    public function update(Request $request, Ship $ship)
    {
        $request->validate([
            'is_verified' => 'required|boolean'
        ]);

        Ship::where('id', $ship->id)
            ->update([
                'is_verified' => $request->is_verified,
                'notes' => !$request->is_verified ? $request->notes : NULL,
            ]);

        return $this->success($ship);
    }
}
