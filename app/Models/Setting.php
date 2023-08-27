<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static pluck(string $string, string $string1)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static where(string $string, int|string $key)
 */
class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value'];
    protected static function rules(): array
    {
        return (
        [
            'app_name' => ['required', 'string'],
            'date_format' => ['required', 'string'],
            'pagination_limit' => ['required', 'int', 'min:1', 'max:100'],
        ]

        );
    }
}
