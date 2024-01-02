<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variabel extends Model
{
    use HasFactory;

    Protected $table = 'employee';

    protected $fillable = [
        'label',
        'status'
    ];

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function employee()
    {
        return $this->belongsTo(Variabel::class);
    }

}
