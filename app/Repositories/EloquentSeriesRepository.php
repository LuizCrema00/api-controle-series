<?php 

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Season;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesFormRequest $request): Series
    {
        return DB::transaction(function () use ($request) {
            $serie = Series::create($request->all());
            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {          //BULK INSERT: INSERCAO DE DADOS DE UMA VEZ SÓ
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);
    
            $episodes = [];
            foreach ($serie->seasons as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {       //BULK INSERT: INSERCAO DE DADOS DE UMA VEZ SÓ
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j
                    ];
                }
            }
            Episode::insert($episodes);
    
            return $serie;
    
            });
    }
}