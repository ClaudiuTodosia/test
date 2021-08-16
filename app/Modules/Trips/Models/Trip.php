<?php

namespace App\Modules\Trips\Models;

use Request;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = ['slug', 'title', 'description', 'start_date', 'end_date', 'location', 'price'];

    /**
     * @return mixed
     */
    public function getFilteredTrips()
    {
        $query = $this->select('slug', 'title', 'description', 'start_date', 'end_date', 'location', 'price');
        $query = $this->filterByTitle($query);
        $query = $this->filterByDescription($query);
        $query = $this->filterByDate($query);
        $query = $this->filterByLocation($query);
        $query = $this->filterByPrice($query);
        $query = $this->sortBy($query);
        return $query->get();
    }

    public function getTripBasedOnSlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function filterBySlug($query)
    {
        if (Request::get('slug'))
            $query->where('slug', Request::get('title'));
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function filterByTitle($query)
    {
        if (Request::get('title'))
            $query->where('title', Request::get('title'));
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function filterByDescription($query)
    {
        if (Request::get('description'))
            $query->where('description', Request::get('description'));
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function filterByDate($query)
    {
        if (Request::get('start_date'))
            $query->where('start_date', '>=', Request::get('start_date'));
        if (Request::get('end_date'))
            $query->where('end_date', '<=', Request::get('end_date'));
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function filterByLocation($query)
    {
        if (Request::get('location'))
            $query->where('location', Request::get('location'));
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function filterByPrice($query)
    {
        if (Request::get('price'))
            $query->where('price', Request::get('price'));
        elseif (Request::get('start_price') && Request::get('end_price'))
            $query->whereBetween('price', [Request::get('start_price'), Request::get('end_price')]);
        elseif (Request::get('start_price'))
            $query->where('price', '>=', Request::get('start_price'));
        elseif (Request::get('end_price'))
            $query->where('price', '<=', Request::get('end_price'));
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    protected function sortBy($query)
    {
        if (Request::get('order_by') && Request::get('order_type') && array_search(Request::get('order_by'), $this->fillable) !== false)
            $query->orderBy(Request::get('order_by'), Request::get('order_type'));
        return $query;
    }
}
