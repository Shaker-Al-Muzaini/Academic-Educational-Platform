<?php  
namespace App\Enums;




use Illuminate\Console\Scheduling\Schedule;

enum AppointmentStatus :int
{
    case Scheduled=1;
    case Confirmed=2;
    case Cancelled=3;

    public function  color():string
    {
        return match ($this){
            AppointmentStatus::Scheduled=>'primary',
            AppointmentStatus::Confirmed=>'success',
            AppointmentStatus::Cancelled=>'danger',
        };
    }
}
