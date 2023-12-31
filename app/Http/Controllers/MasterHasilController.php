<?php

namespace App\Http\Controllers;

use App\Models\MasterHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterHasilController extends Controller
{
    protected $unsur = [
        'msu001'    => 'Perencanaan, pengorganisasian, dan pengendalian Pengawasan Intern',
        'msu002'    => 'Pelaksanaan teknis pengawasan internal',
        'msu003'    => 'Evaluasi Pengawasan Intern'
    ];

    protected $hasilKerja = [
        'mhk001' => 'Konsep rencana strategis pengawasan internal',
        'mhk002' => 'Konsep rencana pengawasan tahunan',
        'mhk003' => 'Laporan Hasil Pemantauan rencana pengawasan tahunan',
        'mhk004' => 'Peraturan/pedoman pengawasan intern',
        'mhk005' => 'Kebijakan pengawasan internal',
        'mhk006' => 'Laporan Hasil Audit Kinerja',
        'mhk007' => 'Laporan Hasil audit dengan tujuan tertentu',
        'mhk008' => 'Laporan Hasil Audit Investigatif/PKKN',
        'mhk009' => 'Laporan Hasil Reviu',
        'mhk010' => 'Laporan Hasil Evaluasi',
        'mhk011' => 'Laporan Hasil Pemantauan',
        'mhk012' => 'Laporan Pemberian Keterangan Ahli',
        'mhk013a' => 'Hasil Telaah (Pengaduan Masyarakat)',
        'mhk013b' => 'Hasil Telaah (Permintaan Aparat)',
        'mhk013c' => 'Hasil Telaah (Pengawasan Lainnya)',
        'mhk014' => 'Laporan Hasil Monitoring Tindak Lanjut',
        'mhk015' => 'Laporan Kegiatan Sosialisasi',
        'mhk016' => 'Laporan Kegiatan bimbingan teknis',
        'mhk017' => 'Laporan Kegiatan asistensi',
        'mhk018' => 'Laporan Hasil Evaluasi',
        'mhk019' => 'Laporan Hasil Telaah Sejawat',
        'mhk020' => 'Laporan Penjaminan Kualitas',
    ];

    protected $pelaksanaTugas = [
        'ngt'   => 'Bukan Gugus Tugas',
        'gt'    => 'Gugus Tugas'
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterHasil = MasterHasil::all();
        return view('admin.master-hasil', [
            'type_menu'         => 'rencana-kinerja',
            'masterHasil'       => $masterHasil,
            'unsur'             => $this->unsur,
            'hasilKerja'        => $this->hasilKerja,
            'pelaksanaTugas'    => $this->pelaksanaTugas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'unsur'                 => 'required',
            'subunsur1'             => 'required',
            'subunsur2'             => 'required',
            'kategori_hasilkerja'   => 'required|unique:master_hasils,kategori_hasilkerja',
            'kategori_pelaksana'    => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);


        MasterHasil::create($validateData);

        $request->session()->put('status', 'Berhasil menambahkan Master Hasil Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah Master Hasil Inspektorat Utama',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterHasil  $masterHasil
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $masterHasil = MasterHasil::where('id_master_hasil', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Master Hasil Pegawai Inspektorat Utama',
            'data'      => $masterHasil
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterHasil  $masterHasil
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterHasil $masterHasil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterHasil  $masterHasil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'unsur'                 => 'required',
            'subunsur1'             => 'required',
            'subunsur2'             => 'required',
            // 'kategori_hasilkerja'   => 'required|unique:master_hasils,kategori_hasilkerja',
            'kategori_pelaksana'    => 'required',
        ];

        $masterHasil = MasterHasil::where('id_master_hasil', $id)->first();

        if($request->kategori_hasilkerja != $masterHasil->kategori_hasilkerja){
            $rules['kategori_hasilkerja'] = 'required|unique:master_hasils,kategori_hasilkerja';
        }else{
            $rules['kategori_hasilkerja'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        MasterHasil::where('id_master_hasil', $id)
        ->update([
            'unsur'     => $request->unsur,
            'subunsur1' => $request->subunsur1,
            'subunsur2' => $request->subunsur2,
            'kategori_hasilkerja' => $request->kategori_hasilkerja,
            'kategori_pelaksana' => $request->kategori_pelaksana,

        ]);

        $request->session()->put('status', 'Berhasil memperbarui Master Hasil Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterHasil  $masterHasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        MasterHasil::where('id_master_hasil', $id)->delete();

        $request->session()->put('status', 'Berhasil menghapus Master Hasil Inspektorat Utama.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Master Hasil Inspektorat Utama',
        ]);
    }

    public function subunsur1($id){
        $subunsur1 = MasterHasil::where('unsur', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Daftar Subunsur 1',
            'data'      => $subunsur1->unique('subunsur1')
        ]);
    }

    public function subunsur2(Request $request, $id){
        $subunsur2 = MasterHasil::where('unsur', $id)
                ->where('subunsur1', $request->subunsur1)
                ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Daftar Subunsur 2',
            'data'      => $subunsur2->unique('subunsur2')
        ]);
    }

    public function kategoriHasil(Request $request, $id){
        $masterHasil = MasterHasil::where('unsur', $id)
                ->where('subunsur1', $request->subunsur1)
                ->where('subunsur2', $request->subunsur2)
                ->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Daftar Subunsur 2',
            'data'      => $masterHasil
        ]);
    }
}
