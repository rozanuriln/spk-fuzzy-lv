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
use App\Models\EmployeeEvaluation;
use App\Models\Fungsi;
use App\Models\Himpunan;
use App\Models\Variabel;
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
            ]);
            Employee::create([
                'nama' => $request->nama,
                'birthDate' => $request->birthDate,
                'address' => $request->address,
                'bobot' => '',
            ]);

            return redirect('employee')->with('Berhasil menambah data!');
        } catch (\Throwable $th) {
            return $th;
            return back()->with('failed', 'Gagal menambah data!' . $th->getMessage());
        }
    }

    public function importData(Request $request)
    {
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
        Session::flash('sukses', 'Data Project Berhasil Diimport!');

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

        ]);
        try {
            $data = ([
                'nama' => $request->nama,
                'birthDate' => $request->birthDate,
                'address' => $request->address,
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

        $evaluation = EmployeeEvaluation::where('employee_id', $id)->get();

        return view('admin.employee.form', compact('id', 'data', 'title', 'evaluation'));
    }

    public function destroy($id)
    {
        //
        Employee::find($id)->delete();
        return redirect('employee')->with('success', 'Berhasil hapus data!');
    }

    public function formPenilaian($id)
    {
        try {
            $data = Variabel::all();
            $title = 'Tambah Penilaian Pegawai';
            $data = (object)[
                'data'                   => Employee::where('id', $id)->first(),
                'variabel'               => $data,
                'type'                   => 'create',
                'route'                  => url('submitEvaluation/' . $id)
            ];
            return view('admin.employee.evaluation', compact('data', 'title'));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function submitEvaluation(Request $request, $id)
    {
        try {
            $list = [];
            $highest = [];
            $bobot = 0;
            $i = 0;
            foreach ($request->variabel_id as $is => $item) { //perulangan untuk mencari variabel yang telah diinput
                $himpunan = Fungsi::join('himpunan_fuzzy', 'himpunan_fuzzy.id', 'fungsi_keanggotaan.himpunan_id')
                    ->where('himpunan_fuzzy.variabel_id', $item)
                    ->select('himpunan_fuzzy.himpunan', 'fungsi_keanggotaan.*')
                    ->get(); // mencari data himpunan dari database berdasarkan variabel id yang  diinput
                // return $himpunan;
                $input = [];
                foreach ($himpunan as $key => $hm) { // perulangan untuk menentukan tiap himpuan yang cocok dengan inputan
                    $cekIndex = 0;
                    $tmpBobot = 0;

                    $fungsi = str_replace('x', $request->nilai[$id], $hm->fungsi); // melakukan perubahan nilai x pada fungsi dengan nilai yang dimasukkan
                    $condition = $fungsi; // variabel untuk menampung kondisi sementara untuk pengecekan nilai
                    $formula = eval("if ($condition) { return '1'; } else { return '0'; }"); // pengecekan nilai fungsi jika nilai input memenuhi kondisi pada fungsi maka akan mengembalikan nilai 1 jika tidak memenuhi maka akan mengembalikan nilai 0
                    if (intval($formula) == 1) { // pengecekan jika kondisi benar(bernilai 1) / input memenuhi kriteria salah satu fungsi
                        if (str_contains($hm->bobot, 'x')) { // pengecakan apakah nilai bobot masih berupa rumus atau sudah berupa bilangan bulat
                            $rumus = str_replace('x', $request->nilai[$id], $hm->bobot); // mengisi nilai x pada rumus penentuan bobot dengan nilai input
                            $hasil = eval('return ' . $rumus . ';'); // eksekusi rumus menggunakan fungsi eval()
                            $tmpBobot = $hasil; // menampung sementara nilai bobot
                        } else { // kondisi jika nilai bobot merupakan bilangan bulat
                            $tmpBobot = $hm->bobot; // menampung sementara nilai bobot
                        }
                        $tmpInput = [ // menampung record yang akan disimpan ke dalam database sebagai history
                            'variabel_id' => $item,
                            'himpunan_id' => $hm->himpunan_id,
                            'himpunan' => $hm->himpunan,
                            'bobot' => $tmpBobot,
                        ];
                        $bobot += $tmpBobot; // menjumlahkan bobot
                        array_push($input, $tmpInput); // menyimpan record history ke dalam array
                    }
                }
                usort($input, function ($first, $second) { // mengurutkan nilai pada bobot dari tertinggi ke terendah
                    return $first['bobot'] < $second['bobot'];
                });
                array_push($highest, $input[0]); // mengambil 1 nilaibobot tertinggi
                array_push($list, $bobot);
            }

            $total = 0;
            for ($i = 0; $i < count($list); $i++) { // melakukan perulangan untuk menyimpan record history penilaian
                $variabel = Variabel::where('id', $request->variabel_id[$i])->first(); // get data tiap variabel berdasarkan id variabel
                $tmpBobot = intval($request->nilai[$i]) > $variabel->min && intval($request->nilai[$i]) <= $variabel->max ? $highest[$i]['bobot'] : 0; // melakukan pengecekan apakah nilai input sesuai kriteria perusahaan yang telah ditentukan (min/max) jika sesuai maka nilai bobot akan disimpan dan jika tidak maka nilai bobot akan dirubah menjadi 0
                $total += doubleval($tmpBobot); // menjumlahkan total nilai bobot
                EmployeeEvaluation::create([ // menyimpan history penilaian
                    'employee_id' => $id,
                    'variabel_id' => $request->variabel_id[$i],
                    'himpunan_id' => $highest[$i]['himpunan_id'],
                    'bobot' => round(doubleval($tmpBobot)),
                ]);
            }
            Employee::where('id', $id)->update(['bobot' => $total]); // mengubah bilai bobot pada data karyawan
            return redirect('employee');
            // return ['total bobot' => $total, 'bobot tiap variabel' => $highest, 'input' => $request->nilai];
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
