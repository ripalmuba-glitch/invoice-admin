<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (Mass Assignable).
     * INI WAJIB ADA!
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Relasi: Satu Klien punya banyak Invoice.
     * (Sudah kita buat sebelumnya, pastikan ada)
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
