<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        if ($roles->isEmpty()) {
            $data = [
                'message' => 'No se encontraron roles',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'roles' => $roles,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $role = Rol::find($id);
        if (!$role) {
            $data = [
                'message' => 'No se encontró el rol',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'role' => $role,
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

        $role = Rol::create([
            'description' => $request->description,
        ]);

        $data = [
            'message' => 'Rol creado exitosamente',
            'role' => $role,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $role = Rol::find($id);

        if (!$role) {
            $data = [
                'message' => 'No se encontró el rol',
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

        $role->description = $request->description;
        $role->save();

        $data = [
            'message' => 'Rol actualizado exitosamente',
            'role' => $role,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $role = Rol::find($id);
        if (!$role) {
            $data = [
                'message' => 'No se encontró el rol',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $role->delete();
        $data = [
            'message' => 'El rol ha sido eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
