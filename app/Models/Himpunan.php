<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Himpunan extends Model
{
    use HasFactory;
    protected $table= "himpunan_fuzzy";
    protected $fillable = ['variabel_id', 'himpunan'];
}
