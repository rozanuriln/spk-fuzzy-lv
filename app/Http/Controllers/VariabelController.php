<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variabel;
use Carbon\Carbon;

class VariabelController extends Controller
{

    public function index()
    {
        //
        $data = Variabel::all();
        $title = 'List Data Variabel';

        return view('admin.variabel.index', compact('data', 'title'));
    }

    public function create()
    {
        //
        $title = 'Tambah Data Variabel';
        $data = (object)[
            'variabel'               => '',
            'kode'                   => '',
            'type'                   => 'create',
            'data'                   => Variabel::all(),
            'route'                  => route('variabel.store')
        ];
        return view('admin.variabel.form', compact('title', 'data'));

    }

    public function store(Request $request)
    {
        return $request;
        // dd($request);
        try {
            $request->validate([
                'variabel' => 'required',
                'kode' => 'required',
            ]);
            Variabel::create([
                'variabel' => $request->variabel,
                'kode' => $request->kode,
            ]);

            return redirect('variabel')->with ('Berhasil menambah data!');
        } catch (\Throwable $th) {
            return $th;
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'variabel' => 'required',
            'kode' => 'required',

        ]);
        try {
            $data = ([
                'variabel' => $request->variabel,
                'kode' => $request->kode,
            ]);

            Variabel::where('id', $id)->update($data);
            return redirect('variabel')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!');
        }
    }

    public function show($id)
    {
        $data = Variabel::where('id', $id)->first();
        $data->route = route('variabel.index');
        $data->type = 'detail';
        $title = 'Detail Data Variabel';
        $project = Variabel::all();

        // code aslinya
        return view('admin.variabel.form', compact('id', 'data', 'title',));
    }

    public function edit($id)
    {
        //
        $data = Variabel::where('id', $id)->first();
        $data->route = route('variabel.update', $id);
        $title = 'Edit Data Variabel';
        return view('admin.variabel.form', compact('data', 'title'));
    }

    public function destroy($id)
    {
        {
            //
            Variabel::find($id)->delete();
            return redirect('variabel')->with('success', 'Berhasil mengubah data!');
        }
    }


}
