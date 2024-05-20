<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['number'];

    protected $casts = [                  //Mapeia um atributo para um tipo
        'watched' => 'bool'
    ];

    public function season() {
        return $this->belongsTo(Season::class);
    }

}
