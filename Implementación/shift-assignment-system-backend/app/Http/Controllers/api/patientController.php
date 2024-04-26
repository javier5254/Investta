<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        if ($patients->isEmpty()) {
            $data = [
                'message' => 'No se encontraron pacientes',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'patients' => $patients,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $data = [
                'message' => 'No se encontró el paciente',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'patient' => $patient,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'dni' => 'required|string|unique:patients,dni',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $patient = Patient::create([
            'name' => $request->name,
            'dni' => $request->dni,
        ]);

        $data = [
            'message' => 'Paciente creado exitosamente',
            'patient' => $patient,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            $data = [
                'message' => 'No se encontró el paciente',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'dni' => 'string|unique:patients,dni,'.$patient->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('name')) {
            $patient->name = $request->name;
        }
        if ($request->has('dni')) {
            $patient->dni = $request->dni;
        }

        $patient->save();

        $data = [
            'message' => 'Paciente actualizado exitosamente',
            'patient' => $patient,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $data = [
                'message' => 'No se encontró el paciente',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $patient->delete();
        $data = [
            'message' => 'El paciente ha sido eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
