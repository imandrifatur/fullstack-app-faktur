<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faktur;
use Illuminate\Support\Facades\Validator;
use App\Models\ItemFaktur;

class FakturController extends Controller
{
    public function index()
    {
        $faktur = Faktur::with('itemFaktur')->get();
        return response()->json($faktur);
    }

    // Mendapatkan detail faktur berdasarkan ID beserta item fakturnya
    public function show($id)
    {
        $faktur = Faktur::with('itemFaktur')->find($id);
        if (!$faktur) {
            return response()->json(['message' => 'Faktur not found'], 404);
        }
        return response()->json($faktur);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pelanggan_id' => 'required|exists:pelanggan,id', // Ganti "pelanggan" dengan tabel pelanggan yang sesuai
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Membuat Faktur
        $faktur = new Faktur;
        $faktur->tanggal = $request->input('tanggal');
        $faktur->pelanggan_id = $request->input('pelanggan_id');
        $faktur->save();

        // Menyimpan ItemFaktur
        $items = $request->input('items');
        foreach ($items as $item) {
            $itemFaktur = new ItemFaktur;
            $itemFaktur->faktur_id = $faktur->id;
            $itemFaktur->barang_id = $item['barang_id'];
            $itemFaktur->jumlah = $item['jumlah'];
            $itemFaktur->diskon = $item['diskon'] ?? 0;
            $itemFaktur->save();
        }

        return response()->json(['message' => 'Faktur created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $faktur = Faktur::find($id);
        if (!$faktur) {
            return response()->json(['message' => 'Faktur not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'pelanggan_id' => 'required|exists:pelanggan,id', // Ganti "pelanggan" dengan tabel pelanggan yang sesuai
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Mengupdate Faktur
        $faktur->tanggal = $request->input('tanggal');
        $faktur->pelanggan_id = $request->input('pelanggan_id');
        $faktur->save();

        // Menghapus semua ItemFaktur terkait faktur ini
        $faktur->itemFaktur()->delete();

        // Menyimpan ItemFaktur yang baru
        $items = $request->input('items');
        foreach ($items as $item) {
            $itemFaktur = new ItemFaktur;
            $itemFaktur->faktur_id = $faktur->id;
            $itemFaktur->barang_id = $item['barang_id'];
            $itemFaktur->jumlah = $item['jumlah'];
            $itemFaktur->diskon = $item['diskon'] ?? 0;
            $itemFaktur->save();
        }

        return response()->json(['message' => 'Faktur updated successfully'], 200);
    }


    public function destroy($id)
{
    $faktur = Faktur::find($id);
    if (!$faktur) {
        return response()->json(['message' => 'Faktur not found'], 404);
    }

    // Menghapus semua ItemFaktur terkait faktur ini
    $faktur->itemFaktur()->delete();

    // Menghapus Faktur itu sendiri
    $faktur->delete();

    return response()->json(['message' => 'Faktur deleted successfully'], 200);
}


}
