<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ParentStudent extends Model
{
    use HasFactory;

    protected $fillable=[
        'email_mother',
        'password_mother',
        'password_Father',
        'email_Father',
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
            'password_Father' => 'required',
            'email_Father' => 'required',
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
            'Address_Mother' => 'required',
            'Nationality_Mother_id' => '',
        ]);

    }


}
