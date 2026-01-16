<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'section_id',
        'duration',
        'total_mark',
        'pass_mark',
        'drip_rule',
        'summary',
        'attempts',
        'sort',
    ];
}
