<?php

namespace App\Modules\Trips\Models;

use App\Modules\Users\Models\User;
use Request;
use Illuminate\Database\Eloquent\Model;

class BookedTrip extends Model
{
    protected $fillable = ['user_id', 'trip_slug'];

    /**
     * @return string|void
     */

    static function saveReservation()
    {
        if (Request::get('slug')) {
            if (!Trip::where('slug', Request::get('slug'))->first())
                $message = 'Trip not founded';
            elseif (!self::checkIfUserHasAlreadyBookedTheTrip(Request::get('slug'))) {
                self::create([
                    'user_id' => \Auth::user()->id,
                    'trip_slug' => Request::get('slug')
                ]);
                $message = 'The trip is booked successfully!';
            } else
                $message = 'This use has already booked this trip!';
            return $message;
        }
    }

    /**
     * @param $slug
     * @return mixed
     */
    static function checkIfUserHasAlreadyBookedTheTrip($slug)
    {
        return self::where('user_id', \Auth::user()->id)
            ->where('trip_slug', $slug)
            ->first();
    }
}
