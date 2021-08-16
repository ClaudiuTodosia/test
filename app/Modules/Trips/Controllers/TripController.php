<?php

namespace App\Modules\Trips\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTripRequest;
use App\Modules\Trips\Models\BookedTrip;
use App\Modules\Trips\Models\Trip;
use Illuminate\Http\JsonResponse;

class TripController extends Controller
{
    protected $filterModel;

    public function __construct()
    {
        $this->filterModel = new Trip();
    }

    /**
     * @param StoreTripRequest $request
     * @return mixed
     */
    public function store(StoreTripRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->filterModel->create($validatedData);
            return response()->json([
                'error' => 0,
                'message' => 'Trip successfully created'
            ]);
        } catch (\Exception $e) {
            return Helper::addCustomLog('Create Trip', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * @return JsonResponse
     */
    public function filter()
    {
        try {
            return response()->json([
                'error' => 0,
                'data' => $this->filterModel->getFilteredTrips()
            ]);
        } catch (\Exception $e) {
            return Helper::addCustomLog('Filter Trip', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function displayTripBasedOnSlug($slug)
    {
        try {
            return response()->json([
                'error' => 0,
                'data' => $this->filterModel->getTripBasedOnSlug($slug)
            ]);
        } catch (\Exception $e) {
            return Helper::addCustomLog('Display Trip', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }

    /**
     * @return JsonResponse
     */

    public function bookTrip()
    {
        try {
            return response()->json([
                'error' => 0,
                'message' => BookedTrip::saveReservation()
            ]);
        } catch (\Exception $e) {
            dd($e);
            return Helper::addCustomLog('Book Trip', $e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
