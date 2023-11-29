<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    Protected $table = 'employee';

    protected $fillable = [
        'user_id',
        'nama',
        'birthDate',
        'alamat',
        'bobot',
    ];

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function position()
    {
        return $this->hasMany(PositionDetail::class, 'user_id', 'id');
    }
}
