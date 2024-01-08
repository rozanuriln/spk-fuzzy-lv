<?php

namespace App\Http\Controllers;

use App\Models\Himpunan;
use Illuminate\Http\Request;

class HimpunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
            //
            $data = Himpunan::all();
            $title = 'List Data Himpunan';

            return view('admin.himpunan.index', compact('data', 'title'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        {
            //
            $title = 'Tambah Data Himpunan';
            $data = (object)[
                'variabel_id'               => '',
                'himpunan'                   => '',
                'type'                   => 'create',
                'route'                  => route('himpunan.store')
            ];
            return view('admin.himpunan.form', compact('title', 'data'));

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        {

            // dd($request);
            try {
                $request->validate([
                    'variabel_id' => 'required',
                    'himpunan' => 'required',
                ]);
                Himpunan::create([
                    'variabel_id' => $request->variabel_id,
                    'himpunan' => $request->kode,
                ]);

                return redirect('himpunan')->with ('Berhasil menambah data!');
            } catch (\Throwable $th) {
                return $th;
                return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        {
            $data = Himpunan::where('id', $id)->first();
            $data->route = route('himpunan.index');
            $data->type = 'detail';
            $title = 'Detail Data Himpunan';
            $project = Himpunan::all();

            // code aslinya
            return view('admin.himpunan.form', compact('id', 'data', 'title',));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Himpunan $himpunan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Himpunan $himpunan)
    {
        //
    }
}
