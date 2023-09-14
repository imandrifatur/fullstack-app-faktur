<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemFaktur extends Model
{
    use HasFactory;
    protected $table = 'item_faktur';

    protected $fillable = ['faktur_id', 'barang_id', 'jumlah', 'diskon'];

    // Definisikan relasi dengan Faktur
    public function faktur()
    {
        return $this->belongsTo(Faktur::class);
    }
}
