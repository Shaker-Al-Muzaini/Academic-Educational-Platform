<?php

namespace App\Http\Controllers\Das;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;


class AppointmentController extends Controller
{
    public function index(){
        $appointments = Appointment::query()
            ->with('client:id,first_name,last_name')
            ->latest()
            ->when(request('status'), fn ($query) =>
            $query->where('status', AppointmentStatus::from(request('status')))
            )
            ->paginate()
            ->through(fn($appoinment)=>[
                'id'=>$appoinment->id,
                'start_time' => (new \DateTime($appoinment->start_time))->format('Y-m-d h:i A'),
                'end_time' => (new \DateTime($appoinment->end_time))->format('Y-m-d h:i A'),

                'status'=>[
                    'name'=>$appoinment->status->name,
                    'color'=>$appoinment->status->color(),
                ],
                'client' => $appoinment->client,
            ]);
        return $appointments;
    }

    public function store()
    {


        // validate
        $validated =request()->validate(Appointment::rules(), [
            'client_id.required' => 'The client name field is required.',
        ]);

        Appointment::create([
            'title' => $validated['title'],
            'client_id' => $validated['client_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'das' => $validated['das'],
            'status' => AppointmentStatus::Scheduled,
        ]);
    }

    public function  update(Appointment $appointment){
        // validate
        $validated =request()->validate(Appointment::rules(), [
            'client_id.required' => 'The client name field is required.',
        ]);
        $appointment->update($validated);
        return response()->json(['success'=>true]);


    }

    public function edit (Appointment $appointment)
    {
        return $appointment;
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(['success' => true], 200);
    }

    public function getAppointmentStatus()
    {
        $cases = AppointmentStatus::cases();
        return collect($cases)->map(fn ($status) => [
            'name' => $status->name,
            'value' => $status->value,
            'count' => Appointment::where('status', $status->value)->count(),
            'color' => AppointmentStatus::from($status->value)->color(),
        ]);
    }


}
