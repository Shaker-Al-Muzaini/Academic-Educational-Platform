<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;


class Grades extends Model
{
    use HasFactory;
    protected $fillable=['name','notes'];
    protected static function rules(): array
    {
        return ([
            'name' => 'required|unique:grades,name,',
            'notes' => 'required',
        ]);

    }
    public function sections()
    {
        return $this->hasMany(Section::class, 'grade_id')->latest();
    }
}
