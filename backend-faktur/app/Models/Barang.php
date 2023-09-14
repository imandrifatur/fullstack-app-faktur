<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';

    // Definisikan relasi dengan ItemFaktur
    public function itemFaktur()
    {
        return $this->hasMany(ItemFaktur::class);
    }
}
