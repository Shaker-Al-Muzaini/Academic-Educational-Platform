<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Explanation extends Model
{
    use HasFactory;
    protected $fillable=['id','notes','name','class_room_id','teacher_id','grade_id'];
    protected static function rules(): array
    {
        return (
        [
            'name' => ['required', 'string', 'username'],
            'class_room_id' => ['required',],
            'grade_id' => ['required',],
            'teacher_id' => ['required',],
            'notes' => ['string',]
        ]
        );
    }
    public  function grade() :BelongsTo
    {
        return $this->belongsTo(Grades::class,'grade_id');
    }

    public  function class_room() :BelongsTo
    {
        return $this->belongsTo(ClassRoom::class,'class_room_id');
    }
    public  function teachers() :BelongsTo
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

}
