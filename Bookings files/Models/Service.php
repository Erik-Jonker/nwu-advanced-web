<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'serviceid';

    protected $table = 'service';

    public function bookings()
    {
        return $this->hasMany(Booking::class,'serivceid');
    }
}
