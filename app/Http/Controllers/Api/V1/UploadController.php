<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function file(Request $request)
    {
        // dd($request->file);
        $file = $request->file('file');
        // dd($file);
        $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
        // dd($nombre_unico);
        Storage::disk('uploads')->put($nombre_unico,  File::get($file));
        return 'uploads/'.$nombre_unico;
    }

    /**
     * Convierte bas64 a archivo png
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function base64_image(Request $request)
    {
        $image = $request->base64;
        $image = explode(',', $image);
        $image = str_replace(' ', '+', $image);
        $nombre_unico = 'images/'.uniqid().'.'.'png';
        Storage::disk('uploads')->put($nombre_unico,  base64_decode($image[1]));
        return 'uploads/'.$nombre_unico;
    }

    /**
     * elimina file
     *
     * @param  string $string
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $image = explode('/', $request->nombre);        
        Storage::disk('uploads')->delete($image[1].'/'.$image[2]);
        return $request->nombre;
    }
}
