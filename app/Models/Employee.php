<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PositionDetail;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'nama',
        'birthDate',
        'address',
        'bobot',
    ];

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function evaluation()
    {
        return $this->hasMany(EmployeeEvaluation::class, 'employee_id', 'id');
    }
}
