<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;

class AdminPembudidayaController extends Controller
{
    public function index()
    {
        $pembudidaya = Pembudidaya::paginate(10);
        return view('admin.pembudidaya.index', compact('pembudidaya'));
    }

    public function create()
    {
        return view('admin.pembudidaya.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pembudidaya,email',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        Pembudidaya::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
        ]);

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);
        return view('admin.pembudidaya.edit', compact('pembudidaya'));
    }

    public function update(Request $request, $id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pembudidaya,email,' . $pembudidaya->id,
            'password' => 'nullable|string|min:6|confirmed',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $pembudidaya->name = $request->name;
        $pembudidaya->email = $request->email;
        if ($request->filled('password')) {
            $pembudidaya->password = bcrypt($request->password);
        }
        $pembudidaya->address = $request->address;
        $pembudidaya->save();

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Data pembudidaya berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);
        $pembudidaya->delete();

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Data pembudidaya berhasil dihapus.');
    }
}
