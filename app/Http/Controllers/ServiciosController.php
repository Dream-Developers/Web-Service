<?php

namespace App\Http\Controllers;

use App\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
    public function servicio(Request $request)
    {
        $servicios = new Servicio();
        if (($request->foto) == null) {
            $servicios->nombre = $request->input('nombre');
            $servicios->descripcion = $request->input('descripcion');

            $servicios->save();

            return response()->json(["mensaje" => 'creado1 correctamente'])
                ->header('Content_Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');

        } else {
            $exploded = explode(',', $request->foto);
            $decode = base64_decode($exploded[0]);
            if (str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
            else
                $extension = 'png';
            $imagen = Carbon::now()->toDateString() ."_".$request->input("nombre"). '_imagen.' . $extension;
            $path = public_path()."/imagen/".$imagen;
            file_put_contents($path, $decode);

            $servicios->nombre = $request->input('nombre');
            $servicios->descripcion = $request->input('descripcion');
            $servicios->foto = $imagen;
            $servicios->save();


            return response()->json(["mensaje"=> 'creado2 correctamente'])
                ->header('Content_Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');

        }
    }
    /*$file = $request->file('imagen');
    $name = $file->getClientOriginalName();
    $file->move(public_path().'/imagenes/',$name);

//si no funciona arriba dejar este
 /*  $file = $request->all();
    if ($archivo = $request ->file('imagen')) {
        $nombre = $archivo->getClientOriginalExtension();
        $archivo->move(public_path() . '/imagen/', $nombre);
    $entrada['imagen']=$nombre;
    }
    Servicio::create($file);

    }*/
    //Jennifer
    public function Recuperar()
    {
        $servicios = Servicio::orderBy("created_at","desc")->get();
        return response()->json([
            'servicio' => $servicios]);

    }

      public function show($id)
    {
        $datosImagen = Servicio::findOrfail($id);
        return response()->json(["servicio"=>$datosImagen]);

    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();
        return response()->json([
            'message' => 'Se borro correctamente'], 201);
    }

    public function update(Request $request){
        if (($request->foto) == null) {

            $this->validate($request, [
                'nombre' => 'required|string|max:500',
                'descripcion' => 'required|string|max:500',
            ]);


            $exploded = explode(',', $request->foto);
            $decode = base64_decode($exploded[0]);
            if (str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
               $extension = 'png';
           $imagen = str_random() . '.' . $extension;
           $path = public_path()."/imagen/".$imagen;
           file_put_contents($path, $decode);

           //buscar la instancia en la base de datos
           $servicio = Servicio::findOrfail($request->id);
           $servicio->nombre = $request->input('nombre');
           $servicio->descripcion = $request->input('descripcion');

           $servicio->save();


           return response()->json(['updated'=> true,
               'message' => 'Se actualizaron los datos correctamente'])
               ->header('Content-Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');

       }else{
            $this->validate($request, [
                'nombre' => 'required|string|max:500',
                'descripcion' => 'required|string|max:500',
            ]);


            $exploded = explode(',', $request->foto);
            $decode = base64_decode($exploded[0]);
            if (str_contains($exploded[0], 'jpeg'))
                $extension = 'jpg';
            $extension = 'png';
            $imagen = str_random() . '.' . $extension;
            $path = public_path()."/imagen/".$imagen;
            file_put_contents($path, $decode);

            //buscar la instancia en la base de datos
            $servicio = Servicio::findOrfail($request->id);
            $servicio->nombre = $request->input('nombre');
            $servicio->descripcion = $request->input('descripcion');
            $servicio->foto = $imagen;

            $servicio->save();


            return response()->json(['updated'=> true,
                'message' => 'Se actualizaron los datos correctamente'])
                ->header('Content-Type', 'application/json')->header('X-Requested-With', 'XMLHttpRequest');
        }}


//


    /*$this->validate($request, [

        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'imagen' => 'required',

    ]);



    $Servicios = new Servicio([

        'nombre' => $request->Nombre,
        'descripcion' => $request->Descripcion,
         $request->Imagen = $name,

    ]);

    $Servicios->save();
    return response()->json([
        'Exito'], 201);
}*/
}
