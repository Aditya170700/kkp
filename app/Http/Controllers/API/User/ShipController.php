<?php

namespace App\Http\Controllers\API\User;

use App\Models\Ship;
use App\Services\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShipController extends Controller
{
    public function index()
    {
        $result = Ship::latest()
            ->where('user_id', auth()->user()->id)
            ->paginate(10)
            ->withQueryString();

        return $this->success($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kapal' => 'required|unique:ships,kode_kapal',
            'nama_kapal' => 'required',
            'nama_pemilik' => 'required',
            'alamat_pemilik' => 'required',
            'ukuran_kapal' => 'required',
            'kapten' => 'required',
            'jumlah_anggota' => 'required',
            'foto_kapal' => 'required|file',
            'nomor_izin' => 'required',
            'dokumen_perizinan' => 'required|file',
        ]);

        $fotoKapal = "";
        if ($request->hasFile('foto_kapal')) {
            $fotoKapal = File::upload('foto-kapal', $request->file('foto_kapal'));
        }

        $dokumenPerizinan = "";
        if ($request->hasFile('dokumen_perizinan')) {
            $dokumenPerizinan = File::upload('dokumen-perizinan', $request->file('dokumen_perizinan'));
        }

        $kapal = Ship::create([
            'user_id' => auth()->user()->id,
            'kode_kapal' => $request->kode_kapal,
            'nama_kapal' => $request->nama_kapal,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat_pemilik' => $request->alamat_pemilik,
            'ukuran_kapal' => $request->ukuran_kapal,
            'kapten' => $request->kapten,
            'jumlah_anggota' => $request->jumlah_anggota,
            'foto_kapal' => $fotoKapal,
            'nomor_izin' => $request->nomor_izin,
            'dokumen_perizinan' => $dokumenPerizinan,
        ]);

        return $this->success($kapal);
    }

    public function update(Request $request, Ship $ship)
    {
        $request->validate([
            'nama_kapal' => 'required',
            'nama_pemilik' => 'required',
            'alamat_pemilik' => 'required',
            'ukuran_kapal' => 'required',
            'kapten' => 'required',
            'jumlah_anggota' => 'required',
            'foto_kapal' => 'required|file',
            'nomor_izin' => 'required',
            'dokumen_perizinan' => 'required|file',
        ]);

        $fotoKapal = $ship->foto_kapal;
        if ($request->hasFile('foto_kapal')) {
            $fotoKapal = File::upload('foto-kapal', $request->file('foto_kapal'));
        }

        $dokumenPerizinan = $ship->dokumen_perizinan;
        if ($request->hasFile('dokumen_perizinan')) {
            $dokumenPerizinan = File::upload('dokumen-perizinan', $request->file('dokumen_perizinan'));
        }

        Ship::where('id', $ship->id)
            ->update([
                'nama_kapal' => $request->nama_kapal,
                'nama_pemilik' => $request->nama_pemilik,
                'alamat_pemilik' => $request->alamat_pemilik,
                'ukuran_kapal' => $request->ukuran_kapal,
                'kapten' => $request->kapten,
                'jumlah_anggota' => $request->jumlah_anggota,
                'foto_kapal' => $fotoKapal,
                'nomor_izin' => $request->nomor_izin,
                'dokumen_perizinan' => $dokumenPerizinan,
            ]);

        return $this->success($ship);
    }
}
