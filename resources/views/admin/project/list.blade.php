@extends('adminlte::page')

@section('title', 'GTE-Builder')

@section('content_header')
    <h1></h1>
@stop


@section('content')
@if(session('error'))
  <div class="alert alert-danger">
    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Erro!</strong>
      Já existe um projeto cadastrado com esse nome!.
  </div>
@endif
<div class="wrapper" style="height: auto; min-height: 100%;">
  <div class="class="content-wrapper"">
    <div class="content-header">
      <section class="content-header">
        <h1>
        <i class="fa fa-fw fa-codepen" style="color: #3c8dbc"></i>
        Projetos
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Projetos</a></li>
      
        </ol>
      </section>
      
      
    </div>
  </div>
</div>


<div class="wrapper" style="height: auto; min-height: 100%;">
  <div class="class="content-wrapper"">
    <div class="content-header">
      
            <div class="content">
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Lista de Projetos</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                  <tr style="background-color: #3c8dbc;color: #FFFFFF;FONT-SIZE: 10PX; ">
                  <th >ID</th>
                  <th>Projeto</th>
                  <th>Data Criação</th>
                  <th></th>
                </tr>

                      @foreach ($result as $project)
                          <tr style="background-color: #b3e2f94a;">


                            <th>{{ $project->id }}</th>
                            <th>{{ $project->name }}</th>
                            <th>{{ date( 'd-m-Y' , strtotime($project->created_at))}}</th>
                            <th><a href="https://localhost/gte-builder/public/home/admin/project/edit/{{ $project->id }}" class="" aria-expanded="true"><i class="fa fa-fw fa-edit"></i></a></th>
                      
                          </tr>
                      @endforeach
              
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
      
    </div>
     
    </div>
  </div>
</div>


            </section>
    </div>
  </div>
</div>     



@stop
