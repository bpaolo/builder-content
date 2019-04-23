<?php

Auth::routes();

//admin


Route::group(['middleware' => ['auth'], 'namespace' => 'Admin'], function(){
	$addresAdmin = '/home/admin';

	Route::get($addresAdmin, 'AdminController@index')->name('admin.home');

	//project
	Route::get($addresAdmin.'/project/list',  'ProjectController@index')->name('admin.project');
	Route::get($addresAdmin.'/project/add',  'ProjectController@add')->name('project.add');	
	Route::post($addresAdmin.'/project/addProject',  'ProjectController@addProject')->name('project.addProject');	
	Route::get($addresAdmin.'/project/edit/{id}',  'ProjectController@edit')->name('	project.addProject');	


	//maquineta
	Route::get($addresAdmin.'/maquineta/list',  'MaquinetaController@list')->name('maquineta.list');

	//template
	Route::post($addresAdmin.'/template/list',  'TemplateController@list')->name('template.list');
	Route::post($addresAdmin.'/template/add',  'TemplateController@add')->name('template.add');
	Route::get($addresAdmin.'/template/edit/{id}',  'TemplateController@edit')->name('template.edit');

	//course
	Route::get($addresAdmin.'/course/listProject/{projectId?}',  'CourseController@listProject')->name('course.listProject');
	Route::post($addresAdmin.'/course/add',  'CourseController@add')->name('course.add');

	//module
	Route::post($addresAdmin.'/module/add',  'ModuleController@add')->name('module.add');
	Route::get($addresAdmin.'/module/listModule/{id?}/{modId?}',  'ModuleController@listModule')->name('module.listModule');

	//element
	Route::post($addresAdmin.'/element/add',  'ElementController@add')->name('element.add');
	Route::get($addresAdmin.'/element/listContent',  'ElementController@list')->name('element.list');

	//content
	Route::post($addresAdmin.'/content/add',  'ContentController@add')->name('content.add');
	Route::get($addresAdmin.'/content/listContent',  'ContentController@listContent')->name('content.listContent');
	
	Route::get($addresAdmin.'/content/edit/{id}/{templateId}',  'ContentController@edit')->name('content.edit');

	Route::get($addresAdmin.'/content/formEdit/{id}/{templateId}', 'ContentController@formEdit')->name('content.formEdit');

	Route::get($addresAdmin.'/content/element/{id}', 'ContentController@element')->name('content.element');

	Route::post($addresAdmin.'/content/save',  'ContentController@save')->name('content.save');
});

Route::group(['middleware' => ['auth'], 'namespace' => 'home'], function(){
	

	Route::get('/home', 'Site\SiteController@index')->name('home');	
});



//Route::get('/home', 'Site\SiteController@index')->name('home');
/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/', 'SiteController@index');



//Route::get('/home', 'HomeController@index')->name('home');





