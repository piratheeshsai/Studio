<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShootPackage;
use Illuminate\Http\Request;

class ShootController extends Controller
{
    //
    public function index()
    {
        return ShootPackage::all();
    }
}
