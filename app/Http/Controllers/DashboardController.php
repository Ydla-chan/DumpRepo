<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rapat;
use Illuminate\Support\Carbon;
use App\Models\Group;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Menyediakan data rapat dalam format JSON untuk FullCalendar.
     */
    public function index()
    {
        $groups = Group::with('users:id,name,email,group_id')->get();
        // 1. Ambil data rapat dari database dengan kolom yang lebih lengkap
        $rapat = Rapat::select('id', 'title', 'date', 'time','location_type', 'invitation')->get();

        // 2. Format data agar sesuai dengan yang dibutuhkan FullCalendar
        $events = $rapat->map(function ($rapat) {
            // Gabungkan tanggal dan jam, lalu format ke standar ISO8601
            $startDateTime = Carbon::parse($rapat->date->format('Y-m-d') . ' ' . $rapat->time);

            return [
                'id'        => $rapat->id,
                'title'     => $rapat->title,
                'start'     => $startDateTime->toIso8601String(),
                'location'  => $rapat->location_type === 'online' ? $rapat->meeting_link : $rapat->room,

            ];
        });

        // 3. Kembalikan view 'test' dan kirim data events yang sudah di-format.
        return view('global.dashboard', ['events' => $events , 'groups' => $groups]);
    }
}