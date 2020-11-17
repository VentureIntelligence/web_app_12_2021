<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $table = 'cprofile';
    protected $primaryKey = 'Company_Id';

    public function balancesheet()
    {
        return $this->hasMany(BalanceSheet::class);
    }

    public function scopeallcompanies($query)
    {
        return DB::select('select cprofile.Company_Id,SCompanyName,FYCount,plstandard.TotalIncome as Revenue,plstandard.EBITDA as EBITDA ,plstandard.PAT as PAT from cprofile , plstandard WHERE plstandard.CId_FK=cprofile.Company_Id group by cprofile.Company_Id ');
        
        // $query
        // ->join('plstandard','plstandard.CId_FK','=','cprofile.Company_Id')
        // ->select('cprofile.Company_Id','SCompanyName','FYCount')
        // ->selectRaw('plstandard.TotalIncome as Revenue,plstandard.EBITDA as EBITDA ,plstandard.PAT as PAT')
        // ->groupBy('cprofile.Company_Id')
        // ->get();
    }

}
