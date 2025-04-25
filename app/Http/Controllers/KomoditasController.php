<?php

namespace App\Http\Controllers;

use App\Models\CommodityType;
use Illuminate\Http\Request;

class KomoditasController extends Controller
{
    public function index()
    {
        $data = CommodityType::all();
        return view('commodity.index', compact('data'));
    }

    public function create()
    {
        return view('commodity.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        CommodityType::create($request->all());
        return redirect()->route('commodity.index')->with('success', 'Komoditas berhasil ditambahkan');
    }
}
