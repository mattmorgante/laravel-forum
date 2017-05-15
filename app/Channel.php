<?php

namespace App;

use App\Http\Controllers\ThreadsController;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads(){
        return $this->hasMany(hread::class);
    }

}
