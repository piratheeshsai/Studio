<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Shoot;
use App\Models\ShootPackage;
use Illuminate\Http\Request;

class ShootController extends Controller
{
    //
    public function index()
    {
        return ShootPackage::all();
    }

     public function shoot()
    {
        $shoots = Shoot::with('client','package')->get();
        return response()->json($shoots);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
       $validated = $request->validate([
        'clientName'  => 'required|string|max:255',
        'clientEmail' => 'nullable|email|max:255',
        'clientPhone' => 'nullable|string|max:20',
        'shootType'   => 'required|string|max:100',
        'date'        => 'required|date',
        'package'     => 'nullable|exists:shoot_packages,id',
    ]);

    // Step 1: Store client (or find existing)
    $client = Client::create([
        'name'  => $validated['clientName'],
        'email' => $validated['clientEmail'],
        'phone' => $validated['clientPhone'],
    ]);

    // Step 2: Store shoot
    $shoot = Shoot::create([
        'client_id'        => $client->id,
        'type'             => $validated['shootType'],
        'shoot_date'       => $validated['date'],
        'shoot_package_id' => $validated['package'],
    ]);

    return response()->json([
        'message' => 'Shoot created successfully',
        'shoot_id' => $shoot->id,
    ], 201);
    }





}
