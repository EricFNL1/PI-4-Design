<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estufa extends Model
{
    use HasFactory;
    public function sensores()
    {
        return $this->hasMany(Sensor::class);
    }
    
    protected $fillable = ['nome'];
}
