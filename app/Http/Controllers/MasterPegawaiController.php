<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class MasterPegawaiController extends Controller
{
    protected $pangkat = [
        'II/a' =>	'Pengatur Muda',
        'II/b' =>	'Pengatur Muda Tingkat I',
        'II/c' => 	'Pengatur',
        'II/d' => 	'Pengatur Tingkat I',
        'III/a' =>	'Penata Muda',
        'III/b' =>	'Penata Muda Tingkat I',
        'III/c' =>	'Penata',
        'III/d' =>	'Penata Tingkat I',
        'IV/a' =>	'Pembina',
        'IV/b' =>	'Pembina Tingkat I',
        'IV/c' =>	'Pembina Muda',
        'IV/d' =>	'Pembina Madya',
        'IV/e' =>	'Pembina Utama'
    ];

    protected $unit_kerja = [
        '8000' => 'Inspektorat Utama',
        '8010' => 'Bagian Umum Inspektorat Utama',
        '8100' => 'Insapektorat Wilayah I',
        '8200' => 'Insapektorat Wilayah II',
        '8300' => 'Insapektorat Wilayah III'
    ];

    protected $jabatan = [
        '21' =>	'Auditor Utama',
        '22' =>	'Auditor Madya',
        '23' =>	'Auditor Muda',
        '24' =>	'Auditor Pertama',
        '25' =>	'Auditor Penyelia',
        '26' =>	'Auditor Pelaksana Lanjutan',
        '27' =>	'Auditor Pelaksana',
        '31' =>	'Perencana Madya',
        '32' =>	'Perencana Muda',
        '33' =>	'Perencana Pertama',
        '41' =>	'Analis Kepegawaian Madya',
        '42' =>	'Analis Kepegawaian Muda',
        '43' =>	'Analis Kepegawaian Pertama',
        '51' =>	'Analis Pengelolaan Keuangan APBN Madya',
        '52' =>	'Analis Pengelolaan Keuangan APBN Muda',
        '53' =>	'Analis Pengelolaan Keuangan APBN Pertama',
        '61' =>	'Pranata Komputer Madya',
        '62' =>	'Pranata Komputer Muda',
        '63' =>	'Pranata Komputer Pratama',
        '71' =>	'Arsiparis Madya',
        '72' =>	'Arsiparis Muda',
        '73' =>	'Arsiparis Pertama',
        '81' =>	'Analis Hukum Madya',
        '82' =>	'Analis Hukum Muda',
        '83' =>	'Analis Hukum Pertama',
        '91' =>	'Penatalaksana Barang',
        '90' =>	'Fungsional Umum'
    ];

    protected $role = [
        'is_admin'      => 'Admin',
        'is_sekma'      => 'Sekretaris Utama',
        'is_sekwil'     => 'Sekretaris Wilayah',
        'is_perencana'  => 'Perencana',
        'is_apkapbn'    => 'APK-APBN',
        'is_opwil'      => 'Operator Wilayah',
        'is_analissdm'  => 'Analis SDM'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $users = User::all();
        return view('admin.master-pegawai.index', [
            'type_menu' => 'master-pegawai',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role
            ])->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view(
            'admin.master-pegawai.create',
            [
                'type_menu'     => 'master-pegawai',
                'pangkat'       => $this->pangkat,
                'unit_kerja'    => $this->unit_kerja,
                'jabatan'       => $this->jabatan,
                'role'          => $this->role
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // protected $role = [
        //     'is_admin'      => 'Admin',
        //     'is_sekma'      => 'Sekretaris Utama',
        //     'is_sekwil'     => 'Sekretaris Wilayah',
        //     'is_perencana'  => 'Perencana',
        //     'is_apkapbn'    => 'APK-APBN',
        //     'is_opwil'      => 'Operator Wilayah',
        //     'is_analissdm'  => 'Analis SDM'
        // ];

        $validateData = $request->validate([
            'name'          => 'required',
            'email'         => 'required|unique:users|max:255',
            'password'      => 'required',
            'nip'           => 'required|max:18',
            'pangkat'       => 'required',
            'unit_kerja'    => 'required',
            'jabatan'       => 'required',
            'is_admin'      => 'required',
            'is_sekma'      => 'required',
            'is_sekwil'     => 'required',
            'is_perencana'  => 'required',
            'is_apkapbn'    => 'required',
            'is_opwil'      => 'required',
            'is_analissdm'  => 'required',
        ]);

        $validateData["password"] = bcrypt($request->password);
        $validateData["is_aktif"] = 1;

        User::create($validateData);

        return redirect('/admin/master-pegawai')->with('success', 'Berhasil menambahkan data pegawai.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrfail($id);

        return view('admin.master-pegawai.show', [
            'type_menu' => 'master-pegawai',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role])
            ->with('user',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        return view('admin.master-pegawai.edit', [
            'type_menu' => 'master-pegawai',
            'pangkat'       => $this->pangkat,
            'unit_kerja'    => $this->unit_kerja,
            'jabatan'       => $this->jabatan,
            'role'          => $this->role])
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);

        $rules = [
            'name'          => 'required',
            // 'email'         => 'required|unique:users|max:255',
            // 'password'      => 'required',
            'nip'           => 'required',
            'pangkat'       => 'required',
            'unit_kerja'    => 'required',
            'jabatan'       => 'required',
            'is_admin'      => 'required',
            'is_sekma'      => 'required',
            'is_sekwil'     => 'required',
            'is_perencana'  => 'required',
            'is_apkapbn'    => 'required',
            'is_opwil'      => 'required',
            'is_analissdm'  => 'required',
        ];

        // if($request->password != ""){
        //     $rules['password'] = 'required';
        //     $request['password'] = $user->password;
        // }else{
        //     $request['password'] = bcrypt($request->password);
        // }

        if($request->email != $user->email){
            $rules['email'] = 'required|unique:users|max:255';
        }

        $validateData = $request->validate($rules);

        User::where('id', $id)->update($validateData);
        return redirect('/admin/master-pegawai')->with('success', 'Berhasil memperbarui data pegawai.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user = User::findOrfail($id);
        User::destroy($id);
        return back()->with('success', 'Berhasil menghapus data pegawai.');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        $validateFile = $request->validate([
            'file' => 'required|mimes::xls,xlsx'
        ]);

        $file = $request->file('file');
        $file_name = rand().$file->getClientOriginalName();
        $file->move('document/upload', $file_name);

        Excel::import(new UserImport, public_path('/document/upload/'.$file_name));
        return back()->with('success', 'Berhasil mengimpor data pegawai.');
    }
}