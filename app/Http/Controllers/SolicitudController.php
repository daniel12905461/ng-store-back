<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Http\Requests\StoreSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $estado = mb_strtoupper($request->input('estado'), "UTF-8");
        $objs = Solicitud::ofestado($estado)->with('planInternet')->with('zona')->get();

        return response()->json(['ok' => true, 'data' => $objs], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $obj = new Solicitud();
        $obj->nombre_completo = $request->input('nombre_completo');
        $obj->ci = $request->input('ci');
        $obj->celular = $request->input('celular');
        $obj->email = $request->input('email');
        $obj->direccion = $request->input('direccion');
        $obj->zona_id = $request->input('zona_id');
        $obj->plan_internet_id = $request->input('plan_internet_id');
        $obj->estado = 'Pendiente';
        $obj->save();

        return response()->json(['ok' => true, 'data' => $obj], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Solicitud $solicitud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSolicitudRequest $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Solicitud $solicitud)
    {
        //
    }
}
