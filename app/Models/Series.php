<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    protected $appends = ['links'];  //informa ao Eloquent que um atributo extra deve ser acessado neste Model. No caso o Accessor

    public function seasons() {
        return $this->hasMany(Season::class, 'series_id');
    }

    public function episodes() {
        return $this->hasManyThrough(Episode::class, Season::class);
    }

    protected static function booted() {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('nome');
        });
    }

    public function links(): Attribute  //Accessor para inserir links e fornecer HATEOAS (deixar a api navegavel por meio de links)
    {
        return new Attribute(
            get: fn() => [
                [
                    'rel' => 'self',
                    'url' => "/api/series/{$this->id}"
                ],
                [
                    'rel' => 'self',
                    'url' => "/api/series/{$this->id}/seasons"
                ],
                [
                    'rel' => 'self',
                    'url' => "/api/series/{$this->id}/episodes"
                ],
            ],
        );

    }
}
