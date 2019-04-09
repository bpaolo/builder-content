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
                    <form role="form" method="POST" action="{{ route('addProject') }}">
                      {!! csrf_field() !!}
                      <div class="box-body">
                        <div class="form-group">
                          <label for="name">Nome Projeto</label>
                          <input name="name" type="text" class="form-control" id="name" placeholder="Digite o nome do projeto">
                        </div>
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
