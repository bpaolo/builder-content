@extends('adminlte::page')


@section('style')
 <style>  
        /*.accordion {  
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
        }*/

/*aba*/

    .abas {
    position: relative;
    }
    .aba {
    display: inline;
    }
    .aba > a {
    float: left;
    padding: 0.5em 1em;
    background: linear-gradient(#FFF, #EEE);
    border-width: 1px;
    border-style: solid;
    border-color: #CCC #CCC #FFF;
    border-top-right-radius: 8px;
    border-top-left-radius: 8px;
    }
    .aba:not(:target) a {
    border-bottom: 0 none;
    }
    .aba:target a, a:hover {
    background: white;
    }
    .conteudo {
    position: absolute;
    left: 0;
    top: calc(2em + 4px); /* altura do link + bordas */
    z-index: -2;
    border: 1px solid #CCC;
    background-color: white;
    }
    .aba:target .conteudo {
    z-index: -1;
    }  


/*carrossel*/

.carousel-fade .carousel-inner .item {
  -webkit-transition-property: opacity;
  transition-property: opacity;
}
.carousel-fade .carousel-inner .item,
.carousel-fade .carousel-inner .active.left,
.carousel-fade .carousel-inner .active.right {
  opacity: 0;
}
.carousel-fade .carousel-inner .active,
.carousel-fade .carousel-inner .next.left,
.carousel-fade .carousel-inner .prev.right {
  opacity: 1;
}
.carousel-fade .carousel-inner .next,
.carousel-fade .carousel-inner .prev,
.carousel-fade .carousel-inner .active.left,
.carousel-fade .carousel-inner .active.right {
  left: 0;
  -webkit-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
}
.carousel-fade .carousel-control {
  z-index: 2;
}

/*
Fade content bs-carousel with hero headers
Code snippet by maridlcrmn (Follow me on Twitter @maridlcrmn) for Bootsnipp.com
Image credits: unsplash.com
*/

/********************************/
/*       Fade Bs-carousel       */
/********************************/
.fade-carousel {
    position: relative;
    height: 100vh;
}
.fade-carousel .carousel-inner .item {
    height: 100vh;
}
.fade-carousel .carousel-indicators > li {
    margin: 0 2px;
    background-color: #f39c12;
    border-color: #f39c12;
    opacity: .7;
}
.fade-carousel .carousel-indicators > li.active {
  width: 10px;
  height: 10px;
  opacity: 1;
}

/********************************/
/*          Hero Headers        */
/********************************/
.hero {
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 3;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    text-shadow: 1px 1px 0 rgba(0,0,0,.75);
      -webkit-transform: translate3d(-50%,-50%,0);
         -moz-transform: translate3d(-50%,-50%,0);
          -ms-transform: translate3d(-50%,-50%,0);
           -o-transform: translate3d(-50%,-50%,0);
              transform: translate3d(-50%,-50%,0);
}
.hero h1 {
    font-size: 6em;    
    font-weight: bold;
    margin: 0;
    padding: 0;
}


.fade-carousel .carousel-inner .item .hero {
    opacity: 0;
    -webkit-transition: 2s all ease-in-out 5s;
       -moz-transition: 2s all ease-in-out 5s; 
        -ms-transition: 2s all ease-in-out 5s; 
         -o-transition: 2s all ease-in-out 5s; 
            transition: 2s all ease-in-out 5s; 
}
.fade-carousel .carousel-inner .item.active .hero {
    opacity: 1;
    -webkit-transition: 2s all ease-in-out 5s;
       -moz-transition: 2s all ease-in-out 5s; 
        -ms-transition: 2s all ease-in-out 5s; 
         -o-transition: 2s all ease-in-out 5s; 
            transition: 2s all ease-in-out 5s;    
}

/********************************/
/*            Overlay           */
/********************************/
.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 2;
    background-color: #080d15;
    opacity: .7;
}

/********************************/
/*          Custom Buttons      */
/********************************/
.btn.btn-lg {padding: 10px 40px;}
.btn.btn-hero,
.btn.btn-hero:hover,
.btn.btn-hero:focus {
    color: #f5f5f5;
    background-color: #1abc9c;
    border-color: #1abc9c;
    outline: none;
    margin: 20px auto;
}

/********************************/
/*       Slides backgrounds     */
/********************************/
.fade-carousel .slides .slide-1, 
.fade-carousel .slides .slide-2,
.fade-carousel .slides .slide-3 {
  height: 100vh;
  background-size: cover;
  background-position: center center;
  background-repeat: no-repeat;
}
.fade-carousel .slides .slide-1 {
  background-image: url(https://ununsplash.imgix.net/photo-1416339134316-0e91dc9ded92?q=75&fm=jpg&s=883a422e10fc4149893984019f63c818); 
}
.fade-carousel .slides .slide-2 {
  background-image: url(https://ununsplash.imgix.net/photo-1416339684178-3a239570f315?q=75&fm=jpg&s=c39d9a3bf66d6566b9608a9f1f3765af);
}
.fade-carousel .slides .slide-3 {
  background-image: url(https://ununsplash.imgix.net/photo-1416339276121-ba1dfa199912?q=75&fm=jpg&s=9bf9f2ef5be5cb5eee5255e7765cb327);
}

/********************************/
/*          Media Queries       */
/********************************/
@media screen and (min-width: 980px){
    .hero { width: 980px; }    
}
@media screen and (max-width: 640px){
    .hero h1 { font-size: 4em; }    
}

/*carrossel 2*/




    </style>     

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
    

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
      {!! html_entity_decode($result->template2) !!}
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
