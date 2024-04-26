<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            $data = [
                'message' => 'No se encontraron usuarios',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'users' => $users,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => 'No se encontró el usuario',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rol_id' => 'required',
            'location_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'location_id' => $request->location_id,
            'rol_id' => $request->rol_id,
        ]);

        $data = [
            'message' => 'Usuario creado exitosamente',
            'user' => $user,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'No se encontró el usuario',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'email|unique:users,email,'.$user->id,
            'password' => 'string|min:6',
            'location_id' => '',
            'rol_id' => '',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->has('location_id')) {
            $user->location_id = $request->location_id;
        }
        if ($request->has('rol_id')) {
            $user->rol_id = $request->rol_id;
        }

        $user->save();

        $data = [
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            $data = [
                'message' => 'No se encontró el usuario',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $user->delete();
        $data = [
            'message' => 'El usuario ha sido eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
