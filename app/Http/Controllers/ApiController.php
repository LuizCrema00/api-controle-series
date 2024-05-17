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
}
