<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Student extends Model
{
    use HasFactory;
    protected $fillable=[
        'address',
        'Gender_id',
        'name',
        'password',
        'email',
        'section_id',
        'grade_id',
        'class_room_id',
        'parent_student_id',
    ];
    protected static function rules(): array
    {
        return (
        [
            'email' => 'required|unique:teachers,email,',
            'Gender_id' => 'required',
            'name' => 'required',
            'password' => 'required',
            'address' => 'required',
            'parent_student_id' => 'required',
            'class_room_id' => 'required',
            'grade_id' => 'required',
            'section_id' => 'required',
        ]
        );
    }



    public  function sections() :BelongsTo
    {
        return $this->belongsTo(Section::class,'section_id');
    }




    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
