<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Tempat;
use App\Models\User;
use App\Models\Ormawa;
use App\Models\Ruangan;
use App\Models\Gedung;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $gedungs = Gedung::all();
        return view('dashboard', compact('gedungs'));
    }
}