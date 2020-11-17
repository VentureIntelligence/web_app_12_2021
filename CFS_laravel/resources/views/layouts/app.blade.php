<!DOCTYPE html>
<html>
<head>
@includeIf('layouts.head')
</head>
<body class="hold-transition layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
 @includeIf('layouts.nav')
 {{-- @includeIf('layouts.sideleft') --}}
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          {{-- <div class="col-sm-6">
            <h1> @yield('pagename')</h1>
          </div> 
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @foreach ($bc as $item)
              @if ($item['active'])
              <li class="breadcrumb-item active">{{$item['name']}}</li>
              @else
              <li class="breadcrumb-item"><a href="{{$item['link']}}">{{$item['name']}}</a></li>
              @endif
              @endforeach
              
            </ol>
          </div>--}}
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @section('content')
        
    @show
   
  </div>
  <!-- /.content-wrapper -->

 @includeIf('layouts.footer')
</body>
</html>
