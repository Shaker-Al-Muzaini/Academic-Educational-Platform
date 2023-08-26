<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 * @method static create(array $array)
 */
class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'title',
        'das',
        'start_time',
        'end_time',
        'status',
    ];
//    protected $appends = ['formatted_start_time', 'formatted_end_time'];

    protected static function rules(): array
    {
        return (
            [
                'client_id' => 'required',
                'title' => 'required',
                'das' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ]

        );
    }

    public  function client() :BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    protected $casts=[
        'status'=>AppointmentStatus::class,
    ];

    public function formatted_start_time(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->start_time->format('Y-m-d h:i A'),
        );
    }

    public function formatted_end_time(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->end_time->format('Y-m-d h:i A'),
        );
    }
}
