<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
    protected $primaryKey = 'state_id';


    public function region()
    {
        $this->blongsTo(Region::class);
    }

    
}
