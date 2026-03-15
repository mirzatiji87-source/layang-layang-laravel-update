<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use App\Models\Score;

class PesertaController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $design = Design::where('user_id', $user->id)->first();
        $finalScore = null;

        if ($design) {
            $scores = Score::where('design_id', $design->id)->get();
            if ($scores->count() > 0) {
                $finalScore = $scores->avg('final_score');
            }
        }

        return view('peserta.dashboard', compact('user', 'design', 'finalScore'));
    }

    public function uploadForm()
    {
        $user = auth()->user();
        $design = Design::where('user_id', $user->id)->first();
        return view('peserta.upload', compact('design'));
    }

    public function uploadDesign(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $user = auth()->user();
        $existing = Design::where('user_id', $user->id)->first();

        // Upload gambar
        $imagePath = $request->file('image')->store('designs', 'public');

        if ($existing) {
            $existing->update([
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $imagePath,
                'status' => 'pending',
            ]);
            return back()->with('success', 'Desain berhasil diperbarui!');
        }

        Design::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Desain berhasil diupload! Menunggu review admin.');
    }

    public function status()
    {
        $user = auth()->user();
        $design = Design::where('user_id', $user->id)->first();
        $scores = null;
        $finalScore = null;

        if ($design) {
            $scores = Score::where('design_id', $design->id)->with('juri')->get();
            if ($scores->count() > 0) {
                $finalScore = $scores->avg('final_score');
            }
        }

        return view('peserta.status', compact('design', 'scores', 'finalScore'));
    }

    public function juknis()
    {
        return view('peserta.juknis');
    }
}