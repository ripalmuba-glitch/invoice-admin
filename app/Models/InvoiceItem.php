<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (Mass Assignable).
     * INI WAJIB ADA!
     */
    protected $fillable = [
        'invoice_id',
        'product_name',
        'quantity',
        'price',
        'total',
    ];
}
