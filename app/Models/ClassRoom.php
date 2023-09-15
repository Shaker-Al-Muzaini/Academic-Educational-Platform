<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable=[
        'grade_id',
        'name_class',
    ];


    protected static function rules(): array
    {
        return (
        [
            'grade_id' => 'required',
            'name_class' => 'required|unique:class_rooms,name_class,',
        ]
        );
    }

    public  function grade() :BelongsTo
    {
        return $this->belongsTo(Grades::class);
    }
}
