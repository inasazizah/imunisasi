<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    use HasFactory;

    protected $table = 'babies';

    protected $fillable = [
        'nama',
        'ttl',
        'bb',
        'done',
        'last_polio',
        'last_dpt',
        'last_mr',
        'user_id',
    ];
}
