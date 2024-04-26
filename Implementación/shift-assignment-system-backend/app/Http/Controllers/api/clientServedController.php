<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientServed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientServedController extends Controller
{
    public function index()
    {
        $clientServed = ClientServed::all();
        if ($clientServed->isEmpty()) {
            $data = [
                'message' => 'No se encontraron registros de clientes atendidos',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'clientServed' => $clientServed,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $clientServed = ClientServed::find($id);
        if (!$clientServed) {
            $data = [
                'message' => 'No se encontró el registro de cliente atendido',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'clientServed' => $clientServed,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift_id' => 'required|exists:shifts,id',
            'user_id' => 'required|exists:users,id',
            'timestamp' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $clientServed = ClientServed::create([
            'shift_id' => $request->shift_id,
            'user_id' => $request->user_id,
            'timestamp' => $request->timestamp,
        ]);

        $data = [
            'message' => 'Registro de cliente atendido creado exitosamente',
            'clientServed' => $clientServed,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $clientServed = ClientServed::find($id);

        if (!$clientServed) {
            $data = [
                'message' => 'No se encontró el registro de cliente atendido',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'shift_id' => 'exists:shifts,id',
            'user_id' => 'exists:users,id',
            'timestamp' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('shift_id')) {
            $clientServed->shift_id = $request->shift_id;
        }
        if ($request->has('user_id')) {
            $clientServed->user_id = $request->user_id;
        }
        if ($request->has('timestamp')) {
            $clientServed->timestamp = $request->timestamp;
        }

        $clientServed->save();

        $data = [
            'message' => 'Registro de cliente atendido actualizado exitosamente',
            'clientServed' => $clientServed,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $clientServed = ClientServed::find($id);
        if (!$clientServed) {
            $data = [
                'message' => 'No se encontró el registro de cliente atendido',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $clientServed->delete();
        $data = [
            'message' => 'El registro de cliente atendido ha sido eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
