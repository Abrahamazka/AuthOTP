<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Mail\BalasanLaporanMail; 
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak valid!',
                'errors'  => $validator->errors()
            ], 422);
        }
        $laporan = Laporan::create([
            'user_id' => $request->user()->id,
            'judul'   => $request->judul,
            'pesan'   => $request->pesan,
            'status'  => 'pending',
        ]);
        return response()->json([
            'message' => 'Laporan berhasil dikirim!',
            'data' => $laporan
        ], 201);
    }

    public function indexAdmin()
    {
        $laporans = Laporan::with('user:id,name,email,foto')->latest()->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar laporan',
            'data'    => $laporans
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $laporan = Laporan::with('user')->find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan!'], 404);
        }

        $laporan->status = $request->status; 
        
        if ($request->has('balasan_admin')) {
            $laporan->balasan_admin = $request->balasan_admin;
        }

        $laporan->save();

        if ($request->status === 'selesai' && $laporan->user) {
            try {
                Mail::to($laporan->user->email)->send(new BalasanLaporanMail($laporan, $request->balasan_admin));
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Status berhasil diperbarui, tapi email gagal terkirim.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['message' => 'Status laporan berhasil diperbarui dan email terkirim!'], 200);
    }

    public function destroy($id)
    {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Laporan tidak ditemukan!'], 404);
        }

        $laporan->delete();

        return response()->json(['message' => 'Laporan berhasil dihapus!'], 200);
    }
}