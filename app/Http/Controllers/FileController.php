<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    public function getFile($filename)
    {
        $path = storage_path('app/public/js/' . $filename); 
        // Check if the file exists
        if (!file_exists($path)) {
            $path = storage_path('app/public/css/' . $filename);
            if (!file_exists($path)) {
                abort(404);
            } 

        }

        // Serve the file with cache control headers
        return Response::file($path, ['Cache-Control' => 'must-revalidate']);
    }
}
