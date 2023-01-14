<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    public function single_venue() {
        return $this->hasOne( Venue::class, 'id', 'venue' );
    }
}
