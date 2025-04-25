<?php

namespace App\Http\Controllers;

use App\Models\Budidaya;
use App\Models\CommodityType;
use Illuminate\Http\Request;

class BudidayaController extends Controller
{
    public function index()
    {
        $data = Budidaya::with('commodityType')->get();
        $commodities = CommodityType::all();

        return view('budidaya.index', compact('data', 'commodities'));
    }

    public function create()
    {
        $commodities = CommodityType::all();
        return view('budidaya.create', compact('commodities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'commodity_type_id' => 'required|exists:commodity_types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'profil_usaha' => 'nullable|string',
            'kapasitas_usaha' => 'nullable|string',
            'proses_budidaya' => 'nullable|string',
            'kendala_produksi' => 'nullable|string',
            'masa_puncak_produksi' => 'nullable|string',
            'produksi_tahunan' => 'nullable|string',
            'pemasaran' => 'nullable|string',
            'kisaran_harga' => 'nullable|string',
            'uji_kualitas_air' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Budidaya::create($request->all());
        return redirect()->route('budidaya.index')->with('success', 'Data budidaya berhasil ditambahkan');
    }
}
