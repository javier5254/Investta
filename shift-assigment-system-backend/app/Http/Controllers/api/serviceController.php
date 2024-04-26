<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        if ($services->isEmpty()) {
            $data = [
                'message' => 'No se encontraron servicios',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'services' => $services,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $service = Service::find($id);
        if (!$service) {
            $data = [
                'message' => 'No se encontró el servicio',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $data = [
            'service' => $service,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'id_rol' => 'required|exists:rols,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $service = Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'id_rol' => $request->id_rol,
        ]);

        $data = [
            'message' => 'Servicio creado exitosamente',
            'service' => $service,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            $data = [
                'message' => 'No se encontró el servicio',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'description' => 'string',
            'id_rol' => 'exists:rols,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hubo un problema con la validación de los campos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('name')) {
            $service->name = $request->name;
        }
        if ($request->has('description')) {
            $service->description = $request->description;
        }
        if ($request->has('id_rol')) {
            $service->id_rol = $request->id_rol;
        }

        $service->save();

        $data = [
            'message' => 'Servicio actualizado exitosamente',
            'service' => $service,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) {
            $data = [
                'message' => 'No se encontró el servicio',
                'status' => 404,
            ];
            return response()->json($data, 404);
        }
        $service->delete();
        $data = [
            'message' => 'El servicio ha sido eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
