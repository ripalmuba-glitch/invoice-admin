<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * --- TAMBAHKAN BLOK INI UNTUK MEMPERBAIKI GARIS MERAH ---
 * * @property int $id
 * @property int $client_id
 * @property string $invoice_number
 * @property string $issue_date
 * @property string $due_date
 * @property string $template
 * @property string $status
 * @property string|null $notes
 * @property float $subtotal
 * @property float $discount
 * @property float $tax
 * @property float $total
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \App\Models\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $items
 * * --- AKHIR BLOK ---
 */
class Invoice extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (Mass Assignable).
     */
    protected $fillable = [
        'client_id',
        'invoice_number', // Pastikan ini ada di $fillable
        'issue_date',
        'due_date',
        'discount',
        'notes',
        'invoice_number',
        'status',
        'subtotal',
        'tax',
        'total',
        'template',
    ];

    // Relasi ke Klien
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    // Relasi ke Item-item Invoice
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
