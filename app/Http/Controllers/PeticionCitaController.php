<?php

namespace App\Http\Controllers;

use App\Cita;
use App\PeticionCita;
use App\servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeticionCitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $citas = PeticionCita::where("User_id","$id")->get();
        return response()->json(["citas"=>$citas])

            ->header('Content_Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');
        ;
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string',
            'Direccion' => 'required|string',
            'Telefono' => 'required',
            'FechaFumigacion' => 'required',
            'Hora' => 'required',
            'User_id'=>'required',
        ]);
        $cita = new PeticionCita([
            'Nombre' => $request->Nombre,
            'Direccion' => $request->Direccion,
            'Telefono' => $request->Telefono,
            'FechaFumigacion' => $request->FechaFumigacion,
            'Hora' => $request->Hora,
            'User_id' => $request->User_id,
            'Estado_id'=>1,

        ]);

        $cita->save();
        return response()->json([
            'message' => 'Successfully created cita!'], 201);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(){
        $citas = PeticionCita::where("Estado_id","1")->get();
        return response()->json(["citas"=>$citas])

            ->header('Content_Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');
        ;
            //
        }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //buscar la instancia en la base de datos
        $servicio = PeticionCita::findOrfail($id);
        $servicio->Estado_id = $request->input('Estado_id');
        $servicio->save();


        return response()->json(['updated'=> true,
            'message' => 'Se actualizaron los datos correctamente'])
            ->header('Content-Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');

    }  //


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cita = PeticionCita::findOrFail($id);
        $cita->delete();
        return response()->json([
            'message' => 'se borro'], 201);
        //
    }
    public function mostrar($id){
        $cliente = PeticionCita::findOrfail($id);

        return response()->json(["cita"=>$cliente]);
    }
}
