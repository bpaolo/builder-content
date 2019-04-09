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
        Dashboard
        <small>administrador</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
        </ol>
      </section>

      <div class="content">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-clone"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Em andamento</span>
                <span class="info-box-number">3</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-clone"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Publicados em Homologação</span>
                <span class="info-box-number">4</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-clone"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Concluídos</span>
                <span class="info-box-number">6</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="fa fa-clone"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Aguardando Template</span>
                <span class="info-box-number"></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Responsive Hover Table</h3>

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
                <tbody><tr>
                  <th>ID</th>
                  <th>Projeto</th>
                  <th>Data Criação</th>
                  <th>Status</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>Projeto 1</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  
                </tr>
                <tr>
                  <td>219</td>
                  <td>Projeto 2</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-warning">Pending</span></td>
                  
                </tr>
                <tr>
                  <td>657</td>
                  <td>Projeto 3</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-primary">Approved</span></td>
                  
                </tr>
                <tr>
                  <td>175</td>
                  <td>Projeto 4</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-danger">Denied</span></td>
                  
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
      
    </div>
  </div>
</div>
@stop
