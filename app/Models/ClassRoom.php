<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static whereIn(string $string, mixed $request)
 */
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
            'name_class' => 'required|unique:class_rooms,name_class,',
            'grade_id' => 'required',
        ]
        );
    }


    public  function grade() :BelongsTo
    {
        return $this->belongsTo(Grades::class,'grade_id');
    }
}
