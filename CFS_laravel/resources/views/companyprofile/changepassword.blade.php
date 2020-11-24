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

@section('content')
<section class="content">
    <div class="row">
      <div class="col-12">
     
        <div class="card mx-auto" style="width: 500px">
          <div class="card-header">
            <h3 class="card-title">Change Password</h3>
            
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <form action="{{ route('cp_post')}}" method="post">
              @csrf
              <div class="form-group ">
                <input type="text" name="newpassword" id="newpassword" class="form-control" placeholder="New Password">
              </div>
              <div class="form-group ">
                <input type="text" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password">
              </div>
              <div class="form-group ">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </form>
           
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
   
</script>
@endsection