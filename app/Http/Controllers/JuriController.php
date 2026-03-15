<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use App\Models\Score;

class JuriController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $totalDesain = Design::where('status', 'approved')->count();
        $sudahDinilai = Score::where('juri_id', $user->id)->count();
        $belumDinilai = $totalDesain - $sudahDinilai;

        return view('juri.dashboard', compact('user', 'totalDesain', 'sudahDinilai', 'belumDinilai'));
    }

    public function daftarDesain()
    {
        $user = auth()->user();
        $designs = Design::where('status', 'approved')
                        ->with('user')
                        ->get();

        $sudahDinilai = Score::where('juri_id', $user->id)
                            ->pluck('design_id')
                            ->toArray();

        return view('juri.desain', compact('designs', 'sudahDinilai'));
    }

    public function detailDesain(Design $design)
    {
        $user = auth()->user();
        $existingScore = Score::where('juri_id', $user->id)
                             ->where('design_id', $design->id)
                             ->first();

        return view('juri.detail', compact('design', 'existingScore'));
    }

    public function simpanNilai(Request $request, Design $design)
    {
        $request->validate([
            'orisinalitas' => 'required|integer|min:0|max:100',
            'estetika'     => 'required|integer|min:0|max:100',
            'budaya'       => 'required|integer|min:0|max:100',
            'teknis'       => 'required|integer|min:0|max:100',
            'catatan'      => 'nullable|string',
        ]);

        $user = auth()->user();

        $finalScore = Score::hitungFinal(
            $request->orisinalitas,
            $request->estetika,
            $request->budaya,
            $request->teknis
        );

        Score::updateOrCreate(
            [
                'juri_id'   => $user->id,
                'design_id' => $design->id,
            ],
            [
                'orisinalitas' => $request->orisinalitas,
                'estetika'     => $request->estetika,
                'budaya'       => $request->budaya,
                'teknis'       => $request->teknis,
                'final_score'  => $finalScore,
                'catatan'      => $request->catatan,
            ]
        );

        return redirect()->route('juri.desain')
                        ->with('success', 'Penilaian berhasil disimpan!');
    }

    public function penilaianSaya()
    {
        $user = auth()->user();
        $scores = Score::where('juri_id', $user->id)
                      ->with('design.user')
                      ->get();

        return view('juri.penilaian', compact('scores'));
    }
}