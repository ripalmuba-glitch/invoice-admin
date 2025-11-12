<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * --- TAMBAHKAN BLOK INI UNTUK MEMPERBAIKI GARIS MERAH ---
 * * @property int $id
 * @property string|null $company_name
 * @property string|null $company_address
 * @property string|null $company_city_state_zip
 * @property string|null $company_phone
 * @property string|null $company_email
 * @property string|null $company_logo
 * @property string|null $default_notes
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * * --- AKHIR BLOK ---
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * Kita gunakan $guarded agar semua kolom bisa diisi
     */
    protected $guarded = [];
}
