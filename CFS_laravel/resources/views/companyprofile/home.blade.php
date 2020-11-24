@extends('layouts.app',['bc'=>[
    ['link'=>route('home'),'name'=>'Home','active'=>true],
    ]])

@section('content')
    {{-- @dd(auth()->user()) --}}
@endsection