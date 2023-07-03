<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjekPengawasan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ObjekPengawasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'id_rencanakerja'   => 'required',
            'objek'          => 'required',
            'kategori_objek'    => 'required',
            'nama'              => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validateData = $request->validate($rules);

        ObjekPengawasan::create([
            'id_rencanakerja'   => $validateData['id_rencanakerja'],
            'id_objek'          => $validateData['objek'],
            'kategori_objek'    => $validateData['kategori_objek'],
            'nama'              => $validateData['nama']
        ]);

        $request->session()->put('status', 'Berhasil menambahkan Objek Pengawasan.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan Objek Pengawasan',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function show(ObjekPengawasan $objekPengawasan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function edit(ObjekPengawasan $objekPengawasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'objek'          => 'required',
            'kategori_objek' => 'required',
            'nama'           => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        ObjekPengawasan::where('id_opengawasan', $request->id_opengawasan)
        ->update([
            'id_objek'          => $request->objek,
            'kategori_objek'    => $request->kategori_objek,
            'nama'              => $request->nama
        ]);

        $request->session()->put('status', 'Berhasil memperbarui Objek Pengawasan.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui Objek Pengawasan',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObjekPengawasan  $objekPengawasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        ObjekPengawasan::where('id_opengawasan', $id)->delete()   ;

        $request->session()->put('status', 'Berhasil menghapus Objek Pengawasan.');
        $request->session()->put('alert-type', 'success');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus Objek Pengawasan',
        ]);
    }
}
