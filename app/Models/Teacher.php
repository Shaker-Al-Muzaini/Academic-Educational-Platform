<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable=[
        'address',
        'joining_Date',
        'Gender_id',
        'specialization_id',
        'name',
        'password',
        'email',
    ];

    protected static function rules(): array
    {
        return (
        [
            'email' => 'required|unique:teachers,email,',
            'Gender_id' => 'required',
            'specialization_id' => 'required',
            'name' => 'required',
            'password' => 'required',
            'address' => 'required',
            'joining_Date' => 'required',
        ]
        );
    }

    public function specializations()
    {
        return $this->belongsTo(specialization::class, 'specialization_id');
    }

    public function formatted_joining_Date(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->joining_Date->format(setting('date_format')),
        );
    }

    // علاقة بين المعلمين والانواع لجلب جنس المعلم
    public function genders()
    {
        return $this->belongsTo(gender::class, 'Gender_id');
    }

// علاقة المعلمين مع الاقسام
    public function Sections()
    {
        return $this->belongsToMany(Section::class,'teacher_sections');
    }
}
