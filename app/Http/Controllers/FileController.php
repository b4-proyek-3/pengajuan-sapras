<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    public function showRuangan($filename)
    {
        $path = storage_path("app/public/uploads/ruangan/{$filename}");
    
        if (!file_exists($path)) {
            abort(404, "File not found: {$filename}");
        }
    
        return response()->file($path);
    }
}
