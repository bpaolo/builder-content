@extends('adminlte::page')


@section('style')
    

    <link href="{{ asset('educacao_midiatica/css/css.css') }}" rel="stylesheet">
    

@show


@section('content_header')
    
    
@stop


@section('content')


{!! html_entity_decode($result->template) !!}




@stop
