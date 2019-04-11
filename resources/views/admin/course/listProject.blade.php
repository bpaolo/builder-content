@extends('adminlte::page')

@section('title', 'GTE-Builder')

@section('content_header')
    <h1></h1>
@stop


@section('content')
<div class="wrapper" style="height: auto; min-height: 100%;">
  <div class="class="content-wrapper"">
    <div class="content-header">
      <section class="content-header">
        <h1>
        Curso
        <small>administrador</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>{{ $result->projectName }}</a></li>
        <li class="active">Curso/cadastrar</li>
        </ol>
      </section>
      <section class="content">
            <div class="row">
              <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                  </div>
                    <form role="form" method="POST" action="{{ route('course.add') }}">
                      {!! csrf_field() !!}
                      <div class="box-body">
                        <div class="form-group">
                          <label for="projectName">Nome Projeto</label>
                          <input name="projectName" type="text" class="form-control" id="projectName" value="{{ $result->projectName }}" disabled>
                        </div>
                        <div class="form-group">
                          <label for="courseName">Nome Curso</label>
                          <input name="courseName" type="text" class="form-control" id="courseName" placeholder="Digite o nome do curso">
                        </div>
                        
                        <div class="form-group">
                          <label for="name">Selecione um Templates</label>
                         
                             <select class="form-control" name="maquinetaId">
                               @foreach ($result->maquineta as $maquineta)
                                <option value="{{ $maquineta->id }}">
                                  {{ $maquineta->name }}
                                </option>
                               @endforeach  
                            
                          
                        </div>
 
                        <input name="projectId" type="hidden" value="{{ $result->projectId }}">
                        
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                      </div>
                    </form>
                </div>
              </div>
             </div>
            <div>
      </section>
    </div>
  </div>
</div>      


@stop
