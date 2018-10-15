<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Booking extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'bookingid';

    protected $table = 'booking';

    public function service()
    {
        return $this->belongsTo(Service::class,'serviceid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
