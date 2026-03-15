<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Design;
use App\Models\Score;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPeserta = User::where('role', 'peserta')->count();
        $verified = User::where('role', 'peserta')->where('is_verified', true)->count();
        $totalDesain = Design::count();
        $dinilai = Design::whereHas('scores')->count();
        $recentPeserta = User::where('role', 'peserta')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPeserta', 'verified', 'totalDesain', 'dinilai', 'recentPeserta'
        ));
    }

    public function peserta()
    {
        $peserta = User::where('role', 'peserta')->with('designs')->get();
        return view('admin.peserta', compact('peserta'));
    }

    public function verifyPeserta(User $user)
    {
        $user->update(['is_verified' => true]);
        return back()->with('success', "{$user->name} berhasil diverifikasi!");
    }

    public function deletePeserta(User $user)
    {
        $user->delete();
        return back()->with('success', 'Peserta berhasil dihapus!');
    }

    public function juri()
    {
        $juris = User::where('role', 'juri')->get();
        return view('admin.juri', compact('juris'));
    }

    public function storeJuri(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'expertise' => 'nullable|string',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make('password'),
            'role'        => 'juri',
            'is_verified' => true,
        ]);

        return back()->with('success', 'Juri berhasil ditambahkan! Password default: password');
    }

    public function deleteJuri(User $user)
    {
        $user->delete();
        return back()->with('success', 'Juri berhasil dihapus!');
    }

    public function desain()
    {
        $designs = Design::with('user', 'scores')->get();
        return view('admin.desain', compact('designs'));
    }

    public function approveDesain(Design $design)
    {
        $design->update(['status' => 'approved']);
        return back()->with('success', 'Desain berhasil disetujui!');
    }

    public function rejectDesain(Design $design)
    {
        $design->update(['status' => 'rejected']);
        return back()->with('success', 'Desain berhasil ditolak!');
    }

    public function penilaian()
    {
        $designs = Design::where('status', 'approved')
                        ->with('user', 'scores')
                        ->get()
                        ->sortByDesc(fn($d) => $d->scores->avg('final_score'));

        return view('admin.penilaian', compact('designs'));
    }

    public function juara()
    {
        $designs = Design::where('status', 'approved')
                        ->with('user', 'scores')
                        ->get()
                        ->sortByDesc(fn($d) => $d->scores->avg('final_score'))
                        ->take(3);

        return view('admin.juara', compact('designs'));
    }

    public function publishJuara()
    {
        // Simpan status published ke settings
        \Illuminate\Support\Facades\Cache::put('juara_published', true);
        return back()->with('success', '🏆 Juara berhasil dipublikasikan!');
    }

    public function toggleLomba(Request $request)
    {
        $status = $request->status === 'buka' ? true : false;
        \Illuminate\Support\Facades\Cache::put('lomba_open', $status);
        $msg = $status ? 'Pendaftaran dibuka!' : 'Pendaftaran ditutup!';
        return back()->with('success', $msg);
    }
}