<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Location;

class SuperAdminController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        $locations = Location::all();

        return view('superAdmin', compact('roles', 'locations'));
    }
}
