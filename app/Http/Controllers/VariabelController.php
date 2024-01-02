<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variabel;

class VariabelController extends Controller
{

    public function index()
    {
        //
        $data = Variabel::all();
        $title = 'List Data Pegawai';

        return view('admin.variabel.index', compact('data', 'title'));
    }
}
