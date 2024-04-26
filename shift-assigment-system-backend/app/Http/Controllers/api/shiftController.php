<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        if ($shifts->isEmpty()) {
            $data = [
                'message' => 'No se encontraron turnos',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'shifts' => $shifts,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $shift = Shift::find($id);
        if (!$shift) {
            $data = [
                'message' => 'No se encontró el turno',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'shift' => $shift,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'service_id' => 'required|exists:services,id',
            'code' => 'required|string',
            'state' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $shift = Shift::create([
            'patient_id' => $request->patient_id,
            'service_id' => $request->service_id,
            'code' => $request->code,
            'state' => $request->state,
        ]);

        $data = [
            'message' => 'Turno creado exitosamente',
            'shift' => $shift,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            $data = [
                'message' => 'No se encontró el turno',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'patient_id' => 'exists:patients,id',
            'service_id' => 'exists:services,id',
            'code' => 'string',
            'state' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('patient_id')) {
            $shift->patient_id = $request->patient_id;
        }
        if ($request->has('service_id')) {
            $shift->service_id = $request->service_id;
        }
        if ($request->has('code')) {
            $shift->code = $request->code;
        }
        if ($request->has('state')) {
            $shift->state = $request->state;
        }

        $shift->save();

        $data = [
            'message' => 'Turno actualizado exitosamente',
            'shift' => $shift,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $shift = Shift::find($id);
        if (!$shift) {
            $data = [
                'message' => 'No se encontró el turno',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $shift->delete();
        $data = [
            'message' => 'El turno ha sido eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
