<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Carbon\CarbonInterface;


class DiaryController extends Controller
{
    public function getDiariesByDay(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $user = $request->user();

        $diaries = Diary::where('username', $user->username)
            ->whereDate('diary_date', $request->date)
            ->orderBy('diary_date', 'desc')
            ->get();

        return response()->json([
            'diaries' => $diaries
        ]);

    }
    public function getDiariesByWeek(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $user = $request->user();
        $start = Carbon::parse($request->start_date)->startOfWeek();
        $end = Carbon::parse($request->end_date)->endOfWeek();

        $diaries = Diary::where('username', $user->username)
            ->whereBetween('diary_date', [$start, $end])
            ->orderBy('diary_date', 'asc')
            ->get();

        return response()->json($diaries);
    }
    public function createDiary(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'diary_date' => 'required|date',
        ]);

        // Kirim konten ke API Python
        $response = Http::post('http://localhost:9000/analyze', [
            'content' => $request->content
        ]);

        $mood = $response->successful() ? $response->json()['mood'] : 'Unknown';

        // Simpan diary
        $diary = Diary::create([
            'username' => $request->user()->username,
            'title' => $request->title,
            'content' => $request->content,
            'mood' => $mood,
            'diary_date' => $request->diary_date,
        ]);

        return response()->json(['message' => 'Diary berhasil disimpan', 'diary' => $diary]);

    }
    
    public function getTodayMood()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $diary = Diary::where('username', $user->username)
            ->whereDate('diary_date', $today)
            ->orderBy('id', 'desc')
            ->first();

        return response()->json([
            'date' => $today,
            'mood' => $diary?->mood ?? null
        ]);
    }
    
    public function getWeeklyMood(Request $request)
    {
        $user = Auth::user();

        // Ambil start_date dari query, default ke minggu ini kalau tidak ada
        $start = Carbon::parse($request->query('start_date', Carbon::now()->startOfWeek(CarbonInterface::MONDAY)));
        $end = $start->copy()->addDays(6); // 7 hari total

        $diaries = Diary::where('username', $user->username)
            ->whereBetween('diary_date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(function ($diary) {
                return Carbon::parse($diary->diary_date)->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst
            });

        // Pastikan semua 7 hari ada walau kosong
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $result = [];

        foreach ($days as $day) {
            $result[$day] = isset($diaries[$day]) ? $diaries[$day]->pluck('mood') : [];
        }

        return response()->json($result);
    }
    public function deleteDiary($id)
    {
        $diary = Diary::find($id);

        if (!$diary) {
            return response()->json(['message' => 'Diary tidak ditemukan'], 404);
        }
        if (!$diary || $diary->username !== auth()->user()->username) {
            return response()->json(['message' => 'Tidak diizinkan'], 403);
        }
        $diary->delete();

        return response()->json(['message' => 'Diary berhasil dihapus']);
    }
    public function updateDiary(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'diary_date' => 'required|date',
        ]);

        $diary = Diary::find($id);

        if (!$diary) {
            return response()->json(['message' => 'Diary tidak ditemukan'], 404);
        }

        if ($diary->username !== auth()->user()->username) {
            return response()->json(['message' => 'Tidak diizinkan'], 403);
        }

        // Kirim ulang konten ke API Python untuk analisis mood baru
        $response = Http::post('http://localhost:9000/analyze', [
            'content' => $request->content
        ]);

        $mood = $response->successful() ? $response->json()['mood'] : $diary->mood;

        $diary->update([
            'title' => $request->title,
            'content' => $request->content,
            'mood' => $mood,
            'diary_date' => $request->diary_date,
        ]);

        return response()->json(['message' => 'Diary berhasil diperbarui', 'diary' => $diary]);
    }

}
