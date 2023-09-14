<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemFaktur;
use Illuminate\Support\Facades\Validator;

class ItemFakturController extends Controller
{
    public function index()
    {
        $itemFaktur = ItemFaktur::all();
        return response()->json($itemFaktur);
    }

    // Mendapatkan detail item faktur berdasarkan ID
    public function show($id)
    {
        $itemFaktur = ItemFaktur::find($id);
        if (!$itemFaktur) {
            return response()->json(['message' => 'Item Faktur not found'], 404);
        }
        return response()->json($itemFaktur);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faktur_id' => 'required|exists:faktur,id',
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Logika untuk menyimpan item faktur
    }
    public function update(Request $request, $id)
    {
        $itemFaktur = ItemFaktur::find($id);
        if (!$itemFaktur) {
            return response()->json(['message' => 'Item Faktur not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'faktur_id' => 'required|exists:faktur,id',
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $itemFaktur->faktur_id = $request->input('faktur_id');
        $itemFaktur->barang_id = $request->input('barang_id');
        $itemFaktur->jumlah = $request->input('jumlah');
        $itemFaktur->diskon = $request->input('diskon');
        $itemFaktur->save();

        return response()->json(['message' => 'Item Faktur updated successfully'], 200);
    }

    public function destroy($id)
    {
        $itemFaktur = ItemFaktur::find($id);
        if (!$itemFaktur) {
            return response()->json(['message' => 'Item Faktur not found'], 404);
        }

        $itemFaktur->delete();
        return response()->json(['message' => 'Item Faktur deleted successfully'], 200);
    }
}
