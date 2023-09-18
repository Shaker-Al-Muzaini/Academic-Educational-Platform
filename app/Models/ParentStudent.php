<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
    use HasFactory;

    protected $fillable=[
        'email_mother',
        'password_mother',
        'Name_Father',
        'National_ID_Father',
        'Phone_Father',
        'Job_Father',
        'Nationality_Father_id',
        'Address_Father',
        'Name_Mother',
        'National_ID_Mother',
        'Phone_Mother',
        'Job_Mother',
        'Nationality_Mother_id',
        'Address_Mother',
    ];

    protected static function rules(): array
    {
        return ([
            'email_mother' => 'required',
            'password_mother' => 'required',
            'Name_Father' => 'required',
            'National_ID_Father' => 'required',
            'Phone_Father' => 'required',
            'Job_Father' => 'required',
            'Nationality_Father_id' => 'required',
            'Address_Father' => 'required',
            'Name_Mother' => 'required',
            'National_ID_Mother' => 'required',
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Nationality_Mother_id' => 'required',
        ]);

    }


}
