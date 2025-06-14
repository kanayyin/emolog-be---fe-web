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

        if ($request->wantsJson()) {
            return response()->json(['diaries' => $diaries]);
        }

        return view('home', [
            'date' => $request->date,
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

        if ($request->wantsJson()) {
            return response()->json($diaries);
        }

        return view('home', [
            'start_date' => $start,
            'end_date' => $end,
            'diaries' => $diaries
        ]);
    }

    public function createDiary(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'diary_date' => 'required|date',
        ]);

        $response = Http::post('http://localhost:9000/analyze', [
            'content' => $request->content
        ]);

        $mood = $response->successful() ? $response->json()['mood'] : 'Unknown';

        $diary = Diary::create([
            'username' => $request->user()->username,
            'title' => $request->title,
            'content' => $request->content,
            'mood' => $mood,
            'diary_date' => $request->diary_date,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Diary berhasil disimpan', 'diary' => $diary]);
        }

        return redirect()->back()->with('success', 'Diary berhasil disimpan');
    }

    public function getTodayMood()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $diary = Diary::where('username', $user->username)
            ->whereDate('diary_date', $today)
            ->orderBy('id', 'desc')
            ->first();

        if (request()->wantsJson()) {
            return response()->json([
                'date' => $today,
                'mood' => $diary?->mood ?? null
            ]);
        }

        return view('home', [
            'date' => $today,
            'mood' => $diary?->mood,
            'content' => $diary?->content
        ]);
    }

    public function getWeeklyMood(Request $request)
    {
        $user = Auth::user();
        $start = Carbon::parse($request->query('start_date', Carbon::now()->startOfWeek(CarbonInterface::MONDAY)));
        $end = $start->copy()->addDays(6);

        $diaries = Diary::where('username', $user->username)
            ->whereBetween('diary_date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(function ($diary) {
                return Carbon::parse($diary->diary_date)->locale('id')->isoFormat('dddd');
            });

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $result = [];

        foreach ($days as $day) {
            $result[$day] = isset($diaries[$day]) ? $diaries[$day]->pluck('mood') : [];
        }

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        $dateRange = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dateRange[] = $date->format('Y-m-d');
        }
        return view('home.home', [
            'moodByDay' => $result,
            'start' => $start,
            'end' => $end,
            'dateRange' => $dateRange,
        ]);
    }

    public function deleteDiary($id)
    {
        $diary = Diary::find($id);

        if (!$diary) {
            return request()->wantsJson()
                ? response()->json(['message' => 'Diary tidak ditemukan'], 404)
                : redirect()->back()->with('error', 'Diary tidak ditemukan');
        }

        if ($diary->username !== auth()->user()->username) {
            return request()->wantsJson()
                ? response()->json(['message' => 'Tidak diizinkan'], 403)
                : redirect()->back()->with('error', 'Tidak diizinkan');
        }

        $diary->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Diary berhasil dihapus']);
        }

        return redirect()->back()->with('success', 'Diary berhasil dihapus');
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
            return request()->wantsJson()
                ? response()->json(['message' => 'Diary tidak ditemukan'], 404)
                : redirect()->back()->with('error', 'Diary tidak ditemukan');
        }

        if ($diary->username !== auth()->user()->username) {
            return request()->wantsJson()
                ? response()->json(['message' => 'Tidak diizinkan'], 403)
                : redirect()->back()->with('error', 'Tidak diizinkan');
        }

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

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Diary berhasil diperbarui', 'diary' => $diary]);
        }

        return redirect()->back()->with('success', 'Diary berhasil diperbarui');
    }
}
