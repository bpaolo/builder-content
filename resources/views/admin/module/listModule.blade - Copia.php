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
        Módulo
        <small>do curso: {{ $result->courseName }}</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>{{ $result->projectName }}</a></li>
        <li><a href="#"></i>{{ $result->courseName }}</a></li>
        <li><a href="#"></i>{{ $result->maquinetaName }}</a></li>
        <li class="active">Módulo/cadastrar</li>
        </ol>
      </section>
      <section class="content">
            <div class="row">
              <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                  </div>
                    <form role="form" method="POST" action="{{ route('module.add') }}">
                      {!! csrf_field() !!}
                      <div class="box-body">
                        <div class="form-group">
                          <label for="moduleName">Nome Módulo</label>
                          <input name="moduleName" type="text" class="form-control" id="moduleName" value="">
                        </div>
                        <div class="form-group">
                          <label for="name">Selecione um Templates</label>
                          @foreach ($result->templates as $temp)
                            <div >
                              <div class="input-group">
                                    <span class="input-group-addon">
                                      <input name="templateId" type="checkbox" value="{{ $temp->id }}">
                                    </span>
                                <input name="templateName" type="text" class="form-control" value="{{ $temp->name}}">
                              </div>
                              <button type="button" data-skin="skin-blue" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">
                          ver
                              </button>
                              <td><a href="#" data-skin="skin-blue" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a></td>

                            </div>
                            <!-- Button trigger modal -->
                        

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="submit" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                              </div>
                                <div class="modal-body">
                                  {!! html_entity_decode($temp->template) !!}
                                </div> 
                              </div>
                              <div class="modal-footer">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                          @endforeach  
                        </div>
                        <input name="projectName" type="hidden" value="{{ $result->projectName }}">
                        <input name="maquinetaId" type="hidden" value="{{ $result->maquinetaId }}">
                        <input name="maquinetaName" type="hidden" value="{{ $result->maquinetaName }}">
                        <input name="courseId" type="hidden" value="{{ $result->courseId }}">
                        <input name="courseName" type="hidden" value="{{ $result->courseName }}">
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
