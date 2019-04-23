@extends('adminlte::page')


@section('style')
    
<script type="text/javascript" src="../../../../../ext/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
  window.onload = function()  {
    CKEDITOR.replace( 'editor1' );
 };
</script>
    
    

@show


@section('content_header')
    
    
@stop


@section('content')

  <form role="form" method="POST" action="{{ route('content.save') }}">
     {!! csrf_field() !!}
    <textarea id="editor1" name="content"></textarea>

    <input name="templateId" type="hidden" value="{{ $result->templateId }}">
    <input name="elementId" type="hidden" value="{{ $result->elementId }}">
    <input type="submit" value="salvar" class="btn btn-block btn-primary"/>
  </form>  
  <div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $result->description }}</h3>
        </div>
        <div class="box-body" style="font-weight:normal !important  ;">
            {!! html_entity_decode($result->modelContent) !!}
        </div>
  </div>

@stop
