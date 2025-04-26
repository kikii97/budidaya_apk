<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembudidaya;
use Illuminate\Support\Facades\Storage;

class AdminPembudidayaController extends Controller
{
    public function index()
    {
        // Urutkan berdasarkan waktu dibuat, terbaru di atas
        $pembudidaya = Pembudidaya::orderBy('created_at', 'desc')->paginate(10);
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
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpeg,png,jpg|max:2048',
        ]);

        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $documents[] = $file->store('documents', 'public');
            }
        }

        // SOLUSI FIX: Gunakan instansiasi manual supaya NULL beneran
        $pembudidaya = new Pembudidaya();
        $pembudidaya->name = $request->name;
        $pembudidaya->email = $request->email;
        $pembudidaya->password = bcrypt($request->password);
        $pembudidaya->address = $request->address;
        $pembudidaya->documents = $documents;
        $pembudidaya->is_approved = null; // NULL beneran, bukan dianggap 0
        $pembudidaya->save();

        return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function approve($id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);

        if (is_null($pembudidaya->is_approved)) {
            $pembudidaya->is_approved = true;
            $pembudidaya->save();
            return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil disetujui.');
        }

        return redirect()->route('admin.pembudidaya.index')->with('error', 'Pembudidaya sudah diproses sebelumnya.');
    }

    public function reject($id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);

        if (is_null($pembudidaya->is_approved)) {
            $pembudidaya->is_approved = false;
            $pembudidaya->save();
            return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil ditolak.');
        }

        return redirect()->route('admin.pembudidaya.index')->with('error', 'Pembudidaya sudah diproses sebelumnya.');
    }

    public function destroy($id)
    {
        $pembudidaya = Pembudidaya::findOrFail($id);

        // Hanya bisa dihapus jika sudah diproses (disetujui atau ditolak)
        if (!is_null($pembudidaya->is_approved)) {
            if (!empty($pembudidaya->documents)) {
                $documents = is_array($pembudidaya->documents) ? $pembudidaya->documents : json_decode($pembudidaya->documents, true);
                foreach ($documents as $doc) {
                    Storage::delete('public/' . $doc);
                }
            }

            $pembudidaya->delete();
            return redirect()->route('admin.pembudidaya.index')->with('success', 'Pembudidaya berhasil dihapus.');
        }

        return redirect()->route('admin.pembudidaya.index')->with('error', 'Hanya pembudidaya yang sudah diproses bisa dihapus.');
    }
}
