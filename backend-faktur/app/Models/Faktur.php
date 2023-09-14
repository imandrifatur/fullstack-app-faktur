<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;

    protected $table = 'faktur';

    protected $fillable = ['tanggal', 'pelanggan_id'];


    public function itemFaktur()
    {
        return $this->hasMany(ItemFaktur::class);
    }
}
