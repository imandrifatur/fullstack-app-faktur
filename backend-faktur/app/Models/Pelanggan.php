<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = ['nama', 'alamat', 'telepon'];


    public function faktur()
    {
        return $this->hasMany(Faktur::class);
    }
}
