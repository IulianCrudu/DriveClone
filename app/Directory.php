<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    //
    public function files()
    {
        return $this->hasMany(File::class)->where('user_id',auth()->id());
    }

    public function directories()
    {

        return $this->hasMany(Directory::class,'parent')->where('user_id',auth()->id());
    }
}
