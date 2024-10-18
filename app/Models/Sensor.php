<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'tipo', 'estufa_id'];

    public function estufa()
    {
        return $this->belongsTo(Estufa::class);
    }
}
