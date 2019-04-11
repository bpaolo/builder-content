@extends('adminlte::page')


@section('style')
 <style>  
        .accordion {  
            background-color: #eee;  
            color: #444;  
            cursor: pointer;  
            padding: 18px;  
            width: 100%;  
            border: none;  
            text-align: left;  
            outline: none;  
            font-size: 15px;  
            transition: 0.4s;  
        }  
  
        .active,  
        .accordion:hover {  
            background-color: #ccc;  
        }  
  
        .panel {  
            padding: 0 18px;  
            display: none;  
            background-color: white;  
            overflow: hidden;  
        }  
    </style>     

    
    

@show


@section('content_header')
    
    
@stop


@section('content')
<div class="wrapper" style="height: auto; min-height: 100%;">
  <div class="class="content-wrapper"">
    <div class="content-header">
      <section class="content-header">
        <h1>
        Projeto
        <small>administrador</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Projeto</a></li>
        <li class="active">cadastrar</li>
        </ol>
      </section>
      <section class="content">
            <div class="row">
              <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                  </div>
                    <form role="form" method="POST" action="{{ route('element.add') }}">
                      {!! csrf_field() !!}
                      <div class="box-body">
                        <div class="form-group">
                        <label>Elementos</label>
                        <select class="form-control" name="elementId">
                          @foreach ($result->elements as $element)
                              <option value="{{ $element->id }}">{{ $element->description }}</option>
                          @endforeach
                        </select>
                      </div>
                      <input name="templateId" type="hidden" value="{{ $result->id }}">
                      
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                      </div>
                    </form>
                </div>
              </div>
             </div>
            <div>

      </section>
      {!! html_entity_decode($result->template) !!}
    </div>
  </div>
</div>   





<script>  
        var acc = document.getElementsByClassName("accordion");  
        var i;  
        for (i = 0; i < acc.length; i++) {  
            acc[i].addEventListener("click", function () {  
                this.classList.toggle("active");  
                var panel = this.nextElementSibling;  
                if (panel.style.display === "block") {  
                    panel.style.display = "none";  
                } else {  
                    panel.style.display = "block";  
                }  
            });  
        }  
    </script>  


@stop
