<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BalanceSheet extends Model
{
    protected $table = 'balancesheet_new';
    protected $primaryKey = 'BalanceSheet_Id';

    public function company()
    {
        $this->belongsToMany(CompanyProfile::class,'CID_FK');
    }
}
