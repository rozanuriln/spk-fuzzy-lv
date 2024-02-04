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
use Carbon\Carbon;


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

    public function create()
    {
        //
        $title = 'Tambah Data Pegawai';
        $data = (object)[
            'nama'                   => '',
            'birthDate'               => '',
            'address'                => '',
            'bobot'                  => '',
            'type'                   => 'create',
            'route'                  => route('employee.store')
        ];
        return view('admin.employee.form', compact('title', 'data'));

    }

    public function store(Request $request)
    {

        // dd($request);
        try {
            $request->validate([
                'nama' => 'required',
                'birthDate' => 'required',
                'address' => 'required',
                'bobot' => 'required',
            ]);
            Employee::create([
                'nama' => $request->nama,
                'birthDate' => $request->birthDate,
                'address' => $request->address,
                'bobot' => $request->bobot,
            ]);

            return redirect('employee')->with ('Berhasil menambah data!');
        } catch (\Throwable $th) {
            return $th;
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    public function importData(Request $request){
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        // $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $name = $file->store('employee', 'public');
        // $file->move('file_siswa',$nama_file);
        $path = storage_path('app/public/' . $name);
        // import data
        $import = new ProjectImport();
        Excel::import($import, $path);

        // notifikasi dengan session
        Session::flash('sukses','Data Project Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect(route('employee.index'));
    }

    public function edit($id)
    {
        //
        $data = Employee::where('id', $id)->first();
        $data->route = route('employee.update', $id);
        $title = 'Edit Data Pegawai';
        return view('admin.employee.form', compact('data', 'title'));
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nama' => 'required',
            'birthDate' => 'required',
            'address' => 'required',
            'bobot' => 'required',

        ]);
        try {
            $data = ([
                'nama' => $request->nama,
                'birthDate' => $request->birthDate,
                'address' => $request->address,
                'bobot' => $request->bobot,
            ]);

            Employee::where('id', $id)->update($data);
            return redirect('employee')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!');
        }
    }

    public function show($id)
    {
        $data = Employee::where('id', $id)->first();
        $data->route = route('employee.index');
        $data->type = 'detail';
        $title = 'Detail Data Pegawai';
        $project = Employee::all();

        // code aslinya
        return view('admin.employee.form', compact('id', 'data', 'title',));
    }

    public function destroy($id)
    {
        //
        Employee::find($id)->delete();
        return redirect('employee')->with('success', 'Berhasil hapus data!');
    }

    
}
