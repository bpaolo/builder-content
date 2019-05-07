
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
        <i class="fa fa-fw fa-codepen" style="color: #3c8dbc"></i>
        Projetos
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>projeto: {{ $result->project[0]->name}}</a></li>
        <li class="active">Projeto/edição</li>
        </ol>
      </section>

      <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="box box-primary">
                	<small></small>
                  <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                  </div>
                    <form role="form" method="POST" action="{{ route('course.add') }}">
                      {!! csrf_field() !!}
                      <div class="box-body">
                        <div >
                          <label for="projectName">{{ $result->project[0]->name }}</label>
                          		<ul class="list-group">
                                		
									<li class="list-group-item" style="border: 0px;">
                  						<a href="https://localhost/gte-builder/public/home/admin/course/listProject/{{$result->project[0]->id}}" class="" aria-expanded="true" >
											<div  style="display: inline; width: 25%; float: right; font-size: 10px;"><i class="fa fa-fw fa-plus-square"></i>adicionar novo curso</div></a>
									</li>
								</ul>
                        </div>
                        
                        <ul class="list-group">
						  
                         		@foreach ($result->project['cursos'] as $c => $curso)
                         		
                                	<ul class="list-group">
                                	<li class="list-group-item" style="background-color: #3c8dbc; color: rgba(255, 255, 255, 0.9); font-size: 20px;">curso : {{ $curso->name }}

										<a href="https://localhost/gte-builder/public/home/admin/module/listModule/{{$curso->id}}" class="" aria-expanded="true">
										<div  style="display: inline; width: 25%; float: right; font-size: 10px; color: #FFFFFF;">
											<i class="fa fa-fw fa-plus-square"></i>adicionar módulo
										</div>
										</a>

                                	</li>
                                	
                                		@foreach ($curso->modulos as $i =>  $modulos)
						  				<li class="list-group-item" style="    background-color: #5fa5ce; color: rgba(255, 255, 255, 0.9);">módulo : {{ $modulos->name }}

						  					<a href="https://localhost/gte-builder/public/home/admin/module/listModule/{{$curso->id}}/{{$modulos->id}}" class="" aria-expanded="true">
						  						<div  style="display: inline; width: 25%; float: right; font-size: 10px; color: #FFFFFF"><i class="fa fa-fw fa-plus-square"></i>  adicionar Página</div>
						  					</a>

						  				
										</li>
										

											<a href="https://localhost/gte-builder/public/home/admin/course/listProject" class="" aria-expanded="true">

											</a>
						  					<ul class="list-group">
						  						
						  						
						  					@foreach ($modulos->template as $t =>  $template)
						  					<li class="list-group-item" style="font-weight:normal; background-color: #b3e2f94a;"><i class="fa fa-fw fa-html5"></i> - {{ $template->name }}<a href="https://localhost/gte-builder/public/home/admin/template/edit/{{ $template->id }}" class="" aria-expanded="true"><i style="margin-right: 300px; " class="fa fa-fw fa-edit"></i></a></li>
						  					@endforeach
						  					
						  					
						  				@endforeach	

									</ul>
                                
                               @endforeach

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



