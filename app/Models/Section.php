<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static latest()
 */
class Section extends Model
{
    use HasFactory;

    protected $fillable=['name','grade_id','class_room_id'];
    protected static function rules(): array
    {
        return (
        [
            'name' => 'required|unique:sections,name,',
            'grade_id' => 'required',
            'class_room_id' => 'required',
            'status'=>'nullable'
        ]
        );
    }


    public function My_class()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class,'teacher_sections');
    }

}
