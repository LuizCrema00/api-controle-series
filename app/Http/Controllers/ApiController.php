<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository) 
    {

    }
    //
    public function index() {
        return Series::all();
    }
    public function store(SeriesFormRequest $request) {
        return response()
            ->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $series) {
        $series = Series::whereId($series)
        ->with('seasons.episodes')
        ->first();
        return $series;
    }

    public function update(Series $series, SeriesFormRequest $request) {
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $series) {
       Series::destroy($series);
       return response()->noContent();
    }
}
