<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 */
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
}
