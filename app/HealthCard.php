<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthCard extends Model
{
    use SoftDeletes;
    protected $table = "health_cards";
    protected $fillable = ['emision', 'conclusion', 'respaldo', 'employee_id'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
