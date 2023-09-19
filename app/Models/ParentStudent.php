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
            'email_mother' => 'nullable',
            'password_mother' => 'nullable',
            'password_Father' => 'nullable',
            'email_Father' => 'nullable',
            'Name_Father' => 'nullable',
            'National_ID_Father' => 'nullable',
            'Phone_Father' => 'nullable',
            'Job_Father' => 'nullable',
            'Nationality_Father_id' => 'nullable',
            'Address_Father' => 'nullable',
            'Name_Mother' => 'nullable',
            'National_ID_Mother' => 'nullable',
            'Phone_Mother' => 'nullable',
            'Job_Mother' => 'nullable',
            'Address_Mother' => 'nullable',
            'Nationality_Mother_id' => 'nullable',
        ]);

    }


}
