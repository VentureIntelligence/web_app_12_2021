@extends('layouts.app',['bc'=>[
  ['link'=>route('home'),'name'=>'Home','active'=>false],
  ['link'=>'','name'=>'Company List','active'=>true],
  ]])

@section('title','Company List')
@section('pagename','Company List')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

@endsection
    <style>
      .dataTables_info{
        font-size: 25px !important;
        font-weight: 400 !important;
        margin-bottom:20px;
      }
    </style>

@section('content')
<section class="content">
    <div class="row">
      <div class="col-3">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Filter</h3>
      
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="form-group">
              <button type="button" class="btn btn-block btn-outline-primary filtercompany">Filter</button>
            </div>
            <div class="form-group">
              <button type="button"  class="btn btn-block btn-outline-success clearfilter">Reset Filter</button>
            </div>  
            <div class="form-group" id="industry_div">
                  <label>INDUSTRY</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="industry">
                    <option value="0">Select Industry</option>
                    @foreach ($industries as $k => $item)
                  <option value="{{ $k }}"> {{ $item }}</option>
                    @endforeach
                  </select>
                </div>
                <div id="sec">
                  <div class="form-group" id="sector_div">
                    <label>SECTOR</label>
                    <select class="form-control select2bs4" style="width: 100%;" id="sector" disabled>
                      <option value="0">Select sector</option>
                     
                    </select>
                  </div>
                </div>
              <div class="form-group">
                  <label>Company Status</label>
                  <select class="select2" multiple="multiple" data-placeholder="Select a Status" style="width: 100%;" id="company_status">
                    <option value="1">Listed</option>
                    <option value="2">Privately held(Ltd)</option>
                    <option value="3">Partnership</option>
                    <option value="4">Proprietorship</option>
                  </select>
                </div>
              <div class="form-group">
                  <label>TRANSACTION STATUS</label>
                  <select class="select2" multiple="multiple" data-placeholder="Select a Transaction Status" style="width: 100%;" id="transaction_status">
                    <option value="0">PE Backed</option>
                    <option value="1">Non-PE Backed</option>
                  </select>
                </div>
                <div class="form-group" id="state_div">
                  <label>State</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="state" multiple="multiple">
                    <option value="0">Select State</option>
                    @foreach ($states as $k => $item)
                  <option value="{{ $k }}"> {{ $item }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group" id="city_div">
                  <label>City</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="city" multiple="multiple">
                    <option value="0">Select City</option>
                    @foreach ($cities as $k => $item)
                  <option value="{{ $k }}"> {{ $item }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group" id="region_div">
                  <label>Region</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="region" multiple="multiple">
                    <option value="0">Select Region</option>
                    <option value="South">South</option>
                    <option value="North">North</option>
                    <option value="West">West</option>
                    <option value="East">East</option>
                    <option value="Central">Central</option>
                  </select>
                </div>
                <div class="row">
                  <label>Year Founded</label>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" id="year_foundaed_div">
                      <select class="form-control select2bs4" style="width: 100%;" id="yearfrom" >
                        <option value="0">from</option>
                        @foreach ($years as $item)
                      <option value="{{ $item }}"> {{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    @php
                        $yearsrv = array_reverse($years);
                    @endphp
                    <div class="form-group" id="year_foundaed_div">
                      <select class="form-control select2bs4" style="width: 100%;" id="yearto" >
                        <option value="0">To</option>
                        @foreach ($yearsrv as $item)
                      <option value="{{ $item }}"> {{ $item }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group" id="frs_div">
                  <label>FINANCIALS RESULT TYPE</label>
                  <select class="form-control select2bs4" style="width: 100%;" id="financials_type" >
                    <option value="0">Standalone</option>
                    <option value="1">Consolidated</option>
                    <option value="both">Both</option>
                  </select>
                </div>
                <div class="form-group" id="an_div">
                  <label>AUDITOR NAME</label>
                  <input type="text" name="auditor_name" id="auditor_name" class="form-control">
                </div>
              <div class="form-group">
                <button type="button" class="btn btn-block btn-outline-primary filtercompany">Filter</button>
              </div>
              <div class="form-group">
                <button type="button"  class="btn btn-block btn-outline-success clearfilter">Reset Filter</button>
              </div>
            </div>
            <!-- /.row -->
      
            
        </div>
      </div>
      <div class="col-9">
     
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">List Companies</h3>
            
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="form-group ">
              <input type="text" name="search_company" id="search_company" class="form-control" placeholder="Search Company">
            </div>
            <table id="companylist" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Company name</th>
                <th>Revenue</th>
                <th>EBITDA</th>
                <th>PAN</th>
                <th>Detailed</th>
              </tr>
              </thead>
              <tbody>
              </tbody>
            
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
@endsection


@section('js')

<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}} "></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}} "></script>

<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>

<script>
    $(function() {
    window.companytable  = $('#companylist').DataTable({
      processing: true,
      serverSide: true,
      pageLength:25,
      deferRender: true,
      "dom": '<"top"il>rt<"bottom"ilp><"clear">',
      ajax: {
          url:"{!! route('companylist') !!}",
         
        },
        "language": {
    processing: '<div class="loading">Loading&#8230;</div>',
    "info": " _TOTAL_ Companies Found",

  },
      columns: [
          { data: 'SCompanyName', name: 'SCompanyName' },
          { data: 'Revenue', name: 'Revenue' },
          { data: 'EBITDA', name: 'EBITDA' },
          { data: 'PAT', name: 'PAT' },
          { data: 'FYCount', name: 'FYCount' },
      ],
      buttons: [
          {
              text: 'My button',
              action: function ( e, dt, node, config ) {
                  alert( 'Button activated' );
              }
          }
      ],
  });
});
$('.select2').select2();

//Initialize Select2 Elements
window.multisel =  $('.select2bs4').select2({
  theme: 'bootstrap4'
});

$('.filtercompany').click(function(){
  $('#companylist').on('preXhr.dt', function (e, settings, data) {
      var industry_id = $('#industry').val();
      var sector = $('#sector').val();
      var company_status = $('#company_status').val();
      var transaction_status = $('#transaction_status').val();
      var state = $('#state').val();
      var region = $('#region').val();
      var city = $('#city').val();
      var yearfrom = $('#yearfrom').val();
      var yearto = $('#yearto').val();
      var financials_type = $('#financials_type').val();
      var auditor_name = $('#auditor_name').val();


      data['industry_id'] = industry_id;
      data['sector'] = sector;
      data['company_status'] = company_status;
      data['transaction_status'] = transaction_status;
      data['state'] = state;
      data['region'] = region;
      data['city'] = city;
      data['yearfrom'] = yearfrom;
      data['yearto'] = yearto;
      data['financials_type'] = financials_type;
      data['auditor_name'] = auditor_name;

      console.log(data);

  });
  window.companytable.draw();
  document.body.scrollTop = 150;
document.documentElement.scrollTop = 150;
});
$('.clearfilter').click(function(){
       $('#industry').val(0);
       $('#sector').val(0);
       $('#yearfrom').val(0);
       $('#yearto').val(0);
       $('#financials_type').val(0);

      $('#company_status,#transaction_status,#state,#region,#city').val(null).trigger('change');
      $('#industry,#sector,#yearfrom,#yearto,#financials_type').val(0).trigger('change');
      document.body.scrollTop = 150;
      document.documentElement.scrollTop = 150;
      window.companytable.draw();
});

function listfiltered(){
      var industrysel = $('#industry').select2('data');
      var sectorsel = $('#sector').select2('data');
      var company_status_sel = $('#company_status').select2('data');
      var transaction_status_sel = $('#transaction_status').select2('data');
      var state_sel = $('#state').select2('data');
      var region_sel = $('#region').select2('data');
      var city_sel = $('#city').select2('data');
      var yearfrom_sel = $('#yearfrom').select2('data');
      var yearto_sel = $('#yearto').select2('data');
      var financials_type_sel = $('#financials_type').select2('data');


}
$('#search_company').keyup(function(){
  $('#companylist').on('preXhr.dt', function (e, settings, data) {
      var search_company = $('#search_company').val();
      data['search_company'] = search_company;
  });
  window.companytable.draw();
  });
// $('#industry').change(function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var industry_id = $('#industry').val();
//       data['industry_id'] = industry_id;
//       data['sector'] = 0;
//       console.log(data);

//   });
//   window.companytable.draw();
// });
// $(document).on('change','#sector',function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var sector = $('#sector').val();
//       data['sector'] = sector;
//       console.log(data);

//   });
//   window.companytable.draw();
// });
// $('#company_status').change(function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var company_status = $('#company_status').val();
//       data['company_status'] = company_status;
//       console.log(data,company_status);

//   });
//   window.companytable.draw();
// });
// $('#transaction_status').change(function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var transaction_status = $('#transaction_status').val();
//       data['transaction_status'] = transaction_status;
//       console.log(data,transaction_status);

//   });
//   window.companytable.draw();
// });

// $('#state').change(function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var state = $('#state').val();
//       data['state'] = state;
//       console.log(data,state);

//   });
//   window.companytable.draw();
// });
// $('#region').change(function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var region = $('#region').val();
//       data['region'] = region;
//       console.log(data,region);

//   });
//   window.companytable.draw();
// });
// $('#city').change(function(){
//   $('#companylist').on('preXhr.dt', function (e, settings, data) {
//       var city = $('#city').val();
//       data['city'] = city;
//       console.log(data,city);

//   });
//   window.companytable.draw();
// });

$('#industry').change(function(){
  if($(this).val() != 0){
    $.ajax({
      type:"GET",
      url:"{{ route('sector.list') }}",
      data : {industry_id:$(this).val()},
      success:function(data){
        $('#sec').html(data);
        $('.select2bs4').select2({
  theme: 'bootstrap4'
});
      }
    })
  }
});
</script>
@endsection