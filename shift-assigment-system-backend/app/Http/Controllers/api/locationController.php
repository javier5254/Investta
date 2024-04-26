<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        if ($locations->isEmpty()) {
            $data = [
                'message' => 'No se encontraron ubicaciones',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'locations' => $locations,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $location = Location::find($id);
        if (!$location) {
            $data = [
                'message' => 'No se encontró la ubicación',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'location' => $location,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $location = Location::create([
            'description' => $request->description,
        ]);

        $data = [
            'message' => 'Ubicación creada exitosamente',
            'location' => $location,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $location = Location::find($id);

        if (!$location) {
            $data = [
                'message' => 'No se encontró la ubicación',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'string|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $location->description = $request->description;
        $location->save();

        $data = [
            'message' => 'Ubicación actualizada exitosamente',
            'location' => $location,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        if (!$location) {
            $data = [
                'message' => 'No se encontró la ubicación',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $location->delete();
        $data = [
            'message' => 'La ubicación ha sido eliminada',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
