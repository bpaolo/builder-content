<?php

use Illuminate\Database\Seeder;
use App\Template;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

Template::create([
            'maquineta_id' => '1', 
            'modulo_id' => '0', 
            'position' => '0', 
            'name' => 'template 1',
            'template' => '<!DOCTYPE html><html><head>    <meta charset=\"utf-8\">    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">    <title>GTE - Builder</title>    <!-- Tell the browser to be responsive to screen width -->    <meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\">    <!-- Bootstrap 3.3.7 -->    <link rel=\"stylesheet\" href=\"http://localhost/gte-builder/public/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css\">    <!-- Font Awesome -->    <link rel=\"stylesheet\" href=\"http://localhost/gte-builder/public/vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css\">    <!-- Ionicons -->    <link rel=\"stylesheet\" href=\"http://localhost/gte-builder/public/vendor/adminlte/vendor/Ionicons/css/ionicons.min.css\">            <!-- Select2 -->                <!-- Theme style -->    <link rel=\"stylesheet\" href=\"http://localhost/gte-builder/public/vendor/adminlte/dist/css/AdminLTE.min.css\">            <!-- DataTables with bootstrap 3 style -->                    <link rel=\"stylesheet\"          href=\"http://localhost/gte-builder/public/vendor/adminlte/dist/css/skins/skin-blue-light.min.css \">            <!--[if lt IE 9]>    <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>    <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>    <![endif]-->    <!-- Google Font -->    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic\"></head><body class=\"hold-transition skin-blue-light sidebar-mini \"><main><article>$allElement</article></main></body><script src=\"http://localhost/gte-builder/public/vendor/adminlte/vendor/jquery/dist/jquery.min.js\"></script><script src=\"http://localhost/gte-builder/public/vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js\"></script><script src=\"http://localhost/gte-builder/public/vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js\"></script>    <!-- Select2 -->        <!-- ChartJS -->        <script src=\"http://localhost/gte-builder/public/vendor/adminlte/dist/js/adminlte.min.js\"></script></html>', 
            'status' => 0, 
            'created_at' => NULL, 
            'updated_at' => NULL, 
            'tipo_template' => 0
        ]);




    }
}
