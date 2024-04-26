<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Shift;

class shiftAssigmentController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('shiftAsignment', compact('services'));
    }
    public function show()
    {
        $shifts = Shift::with('service', 'patient')->get();

        return view('shiftVisualization', compact('shifts'));
    }
}
