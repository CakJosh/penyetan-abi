<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    // Ini adalah 'pintu izin' agar kolom database bisa diisi data
    protected $fillable = ['n', 'h', 'img', 'category'];
}