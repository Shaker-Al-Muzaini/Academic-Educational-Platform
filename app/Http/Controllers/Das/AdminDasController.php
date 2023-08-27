<?php

namespace App\Http\Controllers\Das;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;

class AdminDasController extends Controller
{
    public  function  index ()
    {

        $totalAppointmentsCount = Appointment::query()
            ->when(request('status') === 'scheduled', fn ($query) =>
                $query->where('status', AppointmentStatus::Scheduled)
            )
            ->when(request('status') === 'confirmed', fn ($query) =>
                $query->where('status', AppointmentStatus::Confirmed)
            )
            ->when(request('status') === 'cancelled', fn ($query) =>
                $query->where('status', AppointmentStatus::Cancelled)
            )
            ->count();
        return response()->json([
            'totalAppointmentsCount' => $totalAppointmentsCount,
        ]);
    }

    public function users()
    {
        $totalUsersCount = User::query()
            ->when(request('date_range') === 'today', fn ($query) =>
                $query->whereBetween('created_at', [now()->today(), now()])
            )
            ->when(request('date_range') === '30_days', fn ($query) =>
                $query->whereBetween('created_at', [now()->subDays(30), now()])
            )
            ->when(request('date_range') === '60_days', fn ($query) =>
                $query->whereBetween('created_at', [now()->subDays(60), now()])
            )
            ->when(request('date_range') === '360_days', fn ($query) =>
                $query->whereBetween('created_at', [now()->subDays(360), now()])
            )
            ->when(request('date_range') === 'month_to_date', fn ($query) =>
                $query->whereBetween('created_at', [now()->firstOfMonth(), now()])
            )
            ->when(request('date_range') === 'year_to_date', fn ($query) =>
                $query->whereBetween('created_at', [now()->firstOfYear(), now()])
            )
            ->count();

        return response()->json([
            'totalUsersCount' => $totalUsersCount,
        ]);
    }
}
