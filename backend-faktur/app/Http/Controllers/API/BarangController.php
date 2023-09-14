<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;


class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return response()->json($barang);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string',
            'satuan' => 'required|string',
            'harga_satuan' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $barang = new Barang;
        $barang->nama_barang = $request->input('nama_barang');
        $barang->satuan = $request->input('satuan');
        $barang->harga_satuan = $request->input('harga_satuan');
        $barang->save();

        return response()->json(['message' => 'Barang created successfully'], 201);
    }

    public function show($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }

        $barang->nama_barang = $request->input('nama_barang');
        $barang->satuan = $request->input('satuan');
        $barang->harga_satuan = $request->input('harga_satuan');
        $barang->save();

        return response()->json(['message' => 'Barang updated successfully'], 200);
    }

     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
         $barang = Barang::find($id);
         if (!$barang) {
             return response()->json(['message' => 'Barang not found'], 404);
         }

         $barang->delete();
         return response()->json(['message' => 'Barang deleted successfully'], 200);
     }
}
