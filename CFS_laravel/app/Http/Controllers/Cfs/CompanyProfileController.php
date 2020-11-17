<?php

namespace App\Http\Controllers\Cfs;

use DataTables;
use Carbon\Carbon;
use App\Model\City;
use App\Model\State;
use App\Model\Sector;
use App\Model\Industry;
use App\Model\PlStandard;
use Illuminate\Http\Request;
use App\Model\CompanyProfile;
use App\Http\Controllers\Controller;


class CompanyProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function company()
    {
        $industries = Industry::all()->pluck('IndustryName','Industry_Id');
        $sectorlist = Sector::all()->pluck('SectorName','Sector_Id');
        $states = State::all()->pluck('state_name','state_id');
        $cities = City::all()->pluck('city_name','city_id');

        $lastFiveYear = (int)Carbon::now()->subYears(99)->format('Y');
        $nextYear = (int)Carbon::now()->format('Y');
        $year = Carbon::now()->format('Y');
        $years = [];
        for($i=$lastFiveYear;$i <= $nextYear;$i++ ){
            $years [] =$i;
        }
        return view('companyprofile.company',compact('industries','sectorlist','states','cities','years'));
    }

    public function allCompanies()
    {
        $companies = CompanyProfile::Query()->select('Company_Id','SCompanyName','FYCount','ListingStatus');

        $companies->join('plstandard','cprofile.Company_Id','=','plstandard.CId_FK');

        if(request()->industry_id){
            $companies->where('Industry',request()->industry_id);
        }
        if( !empty(request()->input('search_company')) ){
            $companies->where('SCompanyName', 'like',"%".request()->search_company."%");
        }
        if( !empty(request()->input('auditor_name')) ){
            $companies->where('auditor_name', 'like',"%".request()->auditor_name."%");
        }
        if(isset(request()->sector) && !empty(request()->sector)){
            $companies->where('Sector',request()->sector);
        }
        if(isset(request()->yearfrom) && !empty(request()->yearfrom)){
            $companies->whereBetween('IncorpYear',[request()->yearfrom,request()->yearto]);
        }

        if(isset(request()->company_status)){
            $companies->whereIn('ListingStatus',request()->company_status);
        }
        if(isset(request()->transaction_status)){
            $companies->whereIn('Permissions1',request()->transaction_status);
        }
        if(isset(request()->state)){
            $companies->whereIn('State',request()->state);
        }
        if(isset(request()->city)){
            $companies->whereIn('City',request()->city);
        }
        if(isset(request()->region)){
            $region_states = State::where('Region','South')->pluck('state_id');
            $companies->whereIn('State',$region_states);
        }
        $companies->groupBy('cprofile.Company_Id');
        // return $companies;
        return DataTables::of($companies)
        ->addColumn('Revenue',function($data){
            $revenue = PlStandard::where('CId_FK',$data->Company_Id)->get()->first();
            if(empty($revenue->TotalIncome))
            {
                return '';
            }
        return number_format((float)$revenue->TotalIncome / 10000000,2,'.','');
            })
        ->addColumn('EBITDA',function($data){
            $revenue = PlStandard::where('CId_FK',$data->Company_Id)->get()->first();
            if(empty($revenue->EBITDA))
            {
                return '';
            }
            return number_format((float)$revenue->EBITDA / 10000000,2,'.','');
        })
        ->addColumn('PAT',function($data){
            $revenue = PlStandard::where('CId_FK',$data->Company_Id)->get()->first();
            if(empty($revenue->PAT))
            {
                return '';
            }
            return number_format((float)$revenue->PAT / 10000000,2,'.','');
        })
        ->addColumn('SCompanyName',function($data){
            $lstatus = [
                1=>"<span class='has-tip'>L</span>",
                "<span class='has-tip'>PVT</span>",
                "<span class='has-tip'>PART</span>",
                "<span class='has-tip'>PROP</span>",
            ];
            $Listingstatus = $lstatus[$data->ListingStatus];
            return $Listingstatus." ".$data->SCompanyName;
        })
        ->addColumn('FYCount',function($data){
            $FY = PlStandard::where('CId_FK',$data->Company_Id)->select('FY')->max('FY');
            return "FY".$FY." (upto {$data->FYCount} Years )";
        })
        ->rawColumns(['Revenue','PAT','EBITDA','SCompanyName','FYCount'])
        ->make(true);
        // return Datatables::of(Department::query())->make();
    }

    public function getSectors()
    {
        $indutry_id = request()->industry_id;
        $sectorlist = Sector::where('IndustryId_FK',$indutry_id)->select('Sector_Id','SectorName')->get();
        // dd($sectorlist);
        $sectorhtml = "<div class='form-group' id='sector_div'>
        <label>Sector</label><select class='form-control select2bs4' style='width: 100%;' id='sector'>
          <option value='0'>Select Sector</option>";
          foreach($sectorlist as $sector){
              $sectorhtml .= "<option value='{$sector->Sector_Id}'>{$sector->SectorName}</option>";
          }

          $sectorhtml .= "</select></div>";
          return $sectorhtml;
    }
}
