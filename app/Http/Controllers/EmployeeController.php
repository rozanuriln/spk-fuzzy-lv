<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Position;
use App\Models\PositionDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Imports\ProjectImport;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        //
        $data = Employee::all();
        $title = 'List Data Pegawai';

        return view('admin.employee.index', compact('data', 'title'));
    }
}
