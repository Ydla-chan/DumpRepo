<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapat;
use Illuminate\Support\Carbon;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menyediakan data rapat dalam format JSON untuk FullCalendar.
     */
  

public function index()
{
    $groups = Group::with('users:id,name,email,group_id')->get();

    $emailUser = Auth::user()->email;
    $now = Carbon::now();

       // ✅ Ambil rapat yang dia buat ATAU rapat yang dia diundang
    $rapatsUser = Rapat::with('notulen')
        ->where('pembuat_id', Auth::id())
        ->orWhereJsonContains('undangan', $emailUser)
        ->get();

    // Hitung "Rapat Bulan Ini"
    $countRapatMonth = $rapatsUser->filter(function ($r) use ($now) {
        return $r->tanggal->isSameMonth($now);
    })->count();

    $allTindakans = Auth::user()->tindakans()->get();
    // Hitung tugas yang belum selesai (unfinished)
    $countTugasUnfinished = $allTindakans->where('status', '!=', 'done')->count();

    $events = $rapatsUser->map(function ($rapat) {
        $startDateTime = Carbon::parse($rapat->tanggal->format('Y-m-d') . ' ' . $rapat->jam);
        $location = $rapat->tipe_lokasi === 'online' ? $rapat->link : $rapat->ruangan;

        return [
            'id'        => $rapat->id,
            'title'     => $rapat->judul,
            'start'     => $startDateTime->toIso8601String(),
            'location'  => $location ?? '-',
        ];
    });

    return view('global.dashboard', [
        'events'             => $events,
        'groups'             => $groups,
        'countRapatMonth'    => $countRapatMonth,
        'countTugasUnfinished'=> $countTugasUnfinished,
      
    ]);
}
}