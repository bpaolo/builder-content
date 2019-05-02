
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="http://localhost/gte-builder/public/vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://localhost/gte-builder/public/vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="http://localhost/gte-builder/public/vendor/adminlte/vendor/Ionicons/css/ionicons.min.css">

    <link rel="stylesheet" href="http://localhost/gte-builder/public/vendor/adminlte/dist/css/AdminLTE.min.css">
    <link rel="stylesheet"
          href="http://localhost/gte-builder/public/vendor/adminlte/dist/css/skins/skin-blue-light.min.css ">
  
  <!--<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>-->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    let elementos = []
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
</head>

<body class="hold-transition skin-blue-light sidebar-mini ">
<header class="main-header">
                        <!-- Logo -->
            <a href="http://localhost/gte-builder/public/home" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>GTE-Builder</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>GTE-Builder</b></span><b>
            </b></a><b>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Trocar navegação</span>
                </a>
                            <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li>
                          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <i class="fa fa-fw fa-power-off"></i> Sair
                          </a>
                          <form id="logout-form" action="http://localhost/gte-builder/public/logout" method="POST" style="display: none;">
                          <input type="hidden" name="_token" value="M3uB1cSeyhCrHZiWfaLv5dg7YO8RgyJxHccVpobO">
                          </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </b>
</header>

<main>
<article>


<form role="form" method="POST" id="formulario" action="{{ route('content.order') }}">
                      {!! csrf_field() !!}
<input type="hidden" id="itensOrder" name="itens" />
</form>
@foreach($elements as $elemt)
<script type="text/javascript">elementos.push('{!! html_entity_decode($elemt) !!}')</script>
@endforeach






  <ul id="sortable" onchange="console.log('teste')">
 
  </ul>

  <div class="box-footer">
    <button onclick="cadastro()" class="btn btn-primary"><i class="fa fa-save"></i>  salvar</button>
  </div>

  


<script type="text/javascript">

  let order = []

  $(document).ready(fn => {

    let phpArray = ("{{ $result }}")
    console.log(elementos)
    phpArray = phpArray.split('&quot;').join('"')
    console.log(JSON.parse(phpArray))
    let arrayBanco = JSON.parse(phpArray) || []
    // JSON.parse({{$result}})
    

    arrayBanco.map((elemento, i) => {
      var elementoHTML = elementos[i];
      console.log(elementoHTML)
      $('#sortable').append(`
        <div class="ui-state-default" id="${elemento.id}"><div>${elementoHTML}</div></div>
      `)
    })

    
  })

  $( "#sortable" ).sortable({
        update: function() {
          order = $("#sortable").sortable('toArray');
          
        }
      });

  function cadastro(){
    

console.log(order)

  let request = [];
  order.map((ord, i) => {
    request.push({
      id: parseInt(ord),
      pos: i+1
    })
  })
  console.log(request)

  $('#itensOrder').val(JSON.stringify(request));
  $('#formulario').submit()
  }

 
</script>


</article>
</main>
</body>



</html>




