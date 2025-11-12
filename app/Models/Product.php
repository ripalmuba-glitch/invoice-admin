<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (Mass Assignable).
     * INI WAJIB ADA!
     */
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
