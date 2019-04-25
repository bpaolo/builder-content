@extends('adminlte::page')


@section('style')
    
<script type="text/javascript" src="/gte-builder/public/editor/ckeditor/ckeditor.js"></script>

    

@show


@section('content_header')
    
    
@stop


@section('content')

  <form role="form" method="POST" action="{{ route('content.save') }}">
     {!! csrf_field() !!}
    <textarea id="editor1" name="content">{!! $result->cantent !!}</textarea>
    <script type="text/javascript">
CKEDITOR.replace( 'editor1', {
    filebrowserBrowseUrl: '/gte-builder/public/editor/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '/gte-builder/public/editor/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl: '/gte-builder/public/editor/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl: '/gte-builder/public/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '/gte-builder/public/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl: '/gte-builder/public/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
} );
</script> 

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
