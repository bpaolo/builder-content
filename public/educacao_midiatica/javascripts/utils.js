$('.carousel').carousel({
  pause: true,
  interval: false
})

$('[data-toggle="popover"]').popover({
  trigger: 'focus'
});

$('.interactive-image__btn[data-toggle="popover"]').popover({
  trigger: 'focus'
}).on('shown.bs.popover', function () {
  $('.popover').find('button.popover-next').unbind("click").click(function (e) {
    $('[data-toggle="popover"][aria-describedby]').next('span').next('span').next('button').next('[data-toggle="popover"]').focus();
  });

  $('.popover').find('button.popover-back').unbind("click").click(function (e) {
    $('[data-toggle="popover"][aria-describedby]').prev('button').prev('span').prev('span').prev('[data-toggle="popover"]').focus();
  });
});

jQuery(document).ready(function($) {
  // slider
  $('.my-slider').unslider({
    //infinite: true,
    nav: true,
  });

  // barra progresso que se fixa no topo com scroll
  $('#unit-progress').each(function(){
    var distance = $('#unit-progress').offset().top,
        $window = $(window);

    $window.scroll(function() {
      if ( $window.scrollTop() >= distance ) {
        $('#unit-progress').addClass('progress-fixed');
      }else{
        $('#unit-progress').removeClass('progress-fixed');
      }
    });
  });


  // zoom img
  $('.img-zoom').each(function(){
    $(this).click(function(){
      $('.img-zoomin-area').remove();

      $('body').append("<div class='img-zoomin-area'></div>");
      $('body').css('overflow', 'hidden');
      $(this).addClass('img-zoomin');

      $(this).clone().appendTo('.img-zoomin-area');

      $('.img-zoomin-area').click(function(){
        $(this).addClass('img-zoomout');

        setTimeout(function(){
          $('.img-zoomin-area').remove();
          $('body').css('overflow', 'initial');
          $('.img-zoom').removeClass('img-zoomin');
        }, 200);

      });
    });
  });

  // flip cards
  $('.card-flip').click(function(){
    $(this).toggleClass('is-flipped');
  });

  //sticky table
  $('table.sticky-table').each(function(){
    if($(this).find('thead').length > 0 && $(this).find('th').length > 0){
      // clone thead
      var $w = $(window),
          $t = $(this),
          $thead = $t.find('thead').clone(),
          $col = $t.find('thead, tbody').clone();

      // add class, remove margins, reset width and wrap table
      $t
          .addClass('sticky-enabled')
          .css({
            margin:0,
            width:'auto'
          }).wrap('<div class="sticky-wrap" />');

      if($t.hasClass('overflow-y')){ $t.removeClass('overflow-y').parent().addClass('overflow-y');}

      // create new sticky table thead (basic)
      $t.after('<table class="sticky-thead table"  aria-hidden="true" />');

      // if tbody contains th, then we create sticky column and intersect
      if($t.find('tbody th').length > 0){
        $t.after('<table class="sticky-col table"  aria-hidden="true"/><table class="sticky-intersect table" aria-hidden="true"/>');
      }

      // create shorthand for things
      var $stickyHead = $(this).siblings('.sticky-thead'),
          $stickyCol = $(this).siblings('.sticky-col'),
          $stickyInsct = $(this).siblings('.sticky-intersect'),
          $stickyWrap = $(this).parent('.sticky-wrap');

      $stickyHead.append($thead);

      $stickyCol
          .append($col)
          .find('thead tr:first-child th').remove()
          .end()
          .find('tbody td').remove();

      $stickyInsct.html('<thead><tr><th>' + $t.find('thead th:first-child').html()+'</th></tr></thead>');

      // set widths
      var setWidths = function(){
            $t
            /*.find('thead th').each(function(i){
             $stickyHead.find('th').eq(i).outerWidth($(this).width());
             })
             .end()*/
                .find('tr').each(function(i){
              $stickyCol.find('tr').eq(i).outerHeight($(this).height());
            });

            // set width of sticky table head
            /*$stickyHead.width($t.width());*/

            // set width of sticky table col
            /*$stickyCol.find('th').add($stickyInsct.find('th')).width($t.find('thead th').width())*/
          },
          repositionStickyHead = function(){
            // return value of calculated allowance, seria tipo um valor a mais para evitar sobreposicao do thead quando scroll até o fim
            var allowance = calcAllowance();

            // check if wrapper parent is overflowing along the y-axis
            if($t.height() > $stickyWrap.height()){
              // if it is overflowing
              // position sticky header based on wrapper scrollTop()
              if($stickyWrap.scrollTop() > 0){
                // when top of wrapping parent is out of view
                $stickyHead.add($stickyInsct).css({
                  opacity:1,
                  top:$stickyWrap.scrollTop()
                });
              } else {
                // when top of wrapping parent is in view
                $stickyHead.add($stickyInsct).css({
                  opacity:0,
                  top:0
                });
              }
            } else {
              // if it is not overflowing
              // position sticky header based on viewport scroll top
              if($w.scrollTop() > $t.offset().top && $w.scrollTop() < $t.offset().top + $t.outerHeight() - allowance){
                // when top of viewport is in the table itself
                $stickyHead.add($stickyInsct).css({
                  opacity:1,
                  top:$w.scrollTop() - $t.offset().top
                });
              } else {
                // when top of viewport is above or below table
                $stickyHead.add($stickyInsct).css({
                  opacity:0,
                  top:0
                });
              }
            }
          },
          repositionStickyCol = function(){
            if($stickyWrap.scrollLeft() > 0){
              // when left of wrapping parent is out of view
              $stickyCol.add($stickyInsct).css({
                opacity:1,
                left:$stickyWrap.scrollLeft()
              });
            } else {
              // when left of wrapping parent is in view
              $stickyCol
                  .css({opacity:0})
                  .add($stickyInsct).css({left:0});
            }
          },
          calcAllowance = function(){
            var a = 0;
            // calculate allowance
            $t.find('tbody tr:lt(2)').each(function(){
              a += $(this).height();
            });

            // set fail safe limit (last three row might be too tall)
            // set arbitrary limit at 0.25 of viewport height, or you can use an arbitrary pixel value
            if(a > $w.height()*0.25){
              a = $w.height()*0.25;
            }

            // add the height of sticky header
            a += $stickyHead.height();
            return a;
          };

      setWidths();

      $t.parent('.sticky-wrap').scroll(function(){
        repositionStickyHead();
        repositionStickyCol();
      });

      $w
          .load(setWidths)
          .resize(function(){
            setWidths();
            repositionStickyHead();
            repositionStickyCol();
          })
          .scroll(repositionStickyHead);
    }
  });


  // Progresso scroll tela unidade
  //var scrollArea = $(window);
  var scrollIndicator = $('.unit-banner__content .progress-bar__fill');
  var scrollHeight = 0;
  var scrollOffset = 0;
  var scrollPercent = 0;
  var indicatorPosition = scrollPercent;

  window.animationFrame = (function(){
    return  window.requestAnimationFrame       ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame    ||
        window.oRequestAnimationFrame      ||
        window.msRequestAnimationFrame     ||
        function(/* function */ callback, /* DOMElement */ element){
          window.setTimeout(callback, 1000 / 60);
        };
  })();

  function loop() {
    scrollOffset = window.pageYOffset || window.scrollTop;
    scrollHeight = $('html').height() - window.innerHeight;
    scrollPercent = scrollOffset/scrollHeight || 0;
    indicatorPosition += (scrollPercent-indicatorPosition)*0.05;
    var widthString = indicatorPosition*100;
    scrollIndicator.css('width', widthString+'%');
    //console.log(scrollPercent);

    animationFrame(loop);
  }
  loop();

  function resize() {
    scrollHeight = $('html').height() - window.innerHeight;
    //scrollArea.height = (window.innerHeight*5)+'px';
  }
  resize();
  window.addEventListener('resize', resize);


  // Ajustes acessibilidade abas/tabs
  var targettab;
  $('.nav-tabs-next').click(function(){
    $(this).parent('.tab-pane').removeClass('active').removeClass('in');
    $(this).parent('.tab-pane').next().addClass('active in');

    targettab = $(this).attr('data-tab');
    $('.nav-tabs > li > a[href="#'+targettab+'"]').parent().siblings().removeClass('active');
    $('.nav-tabs > li > a[href="#'+targettab+'"]').parent().addClass('active');
    $('.nav-tabs > li > a[href="#'+targettab+'"]').parent().siblings().find('a').attr('aria-expanded', false );
    $('.nav-tabs > li > a[href="#'+targettab+'"]').attr('aria-expanded', true);
  });

  $('.nav-tabs-back').click(function(){
    $(this).parent('.tab-pane').removeClass('active').removeClass('in');
    $(this).parent('.tab-pane').prev().addClass('active in');

    targettab = $(this).attr('data-tab');
    $('.nav-tabs > li > a[href="#'+targettab+'"]').parent().siblings().removeClass('active');
    $('.nav-tabs > li > a[href="#'+targettab+'"]').parent().addClass('active');
    $('.nav-tabs > li > a[href="#'+targettab+'"]').parent().siblings().find('a').attr('aria-expanded', false );
    $('.nav-tabs > li > a[href="#'+targettab+'"]').attr('aria-expanded', true);
  });


  // Ajuste acessibilidade popover
  $('button[data-toggle="popover"]').each(function(){
    var popovertext = $(this).html();
    var popoverdesc = $(this).attr('data-content');
    var attr = $(this).attr('data-title');
    var popovertitle = '';

    if ( typeof attr !== typeof undefined && attr !== false ){
      popovertitle = $(this).attr('data-title');
    }

    $(this).before('<button class="sr-only popover-sr-button">' + popovertext + '</button>');
    $(this).after('<span tabindex="0" class="sr-only popover-sr-desc" style="display: none; position: static;">Detalhes do trecho: ' + popovertitle + ' ' + popoverdesc + '</span><span tabindex="0" class="sr-only popover-sr-end-button" style="display: none; position:relative;">Fim dos detalhes do trecho</span>');

    $('.popover-sr-button').click(function(){
      //$(this).next('button').focus();
      $(this).next('button').next('.popover-sr-desc').next('.popover-sr-end-button').show();
      $(this).next('button').next('.popover-sr-desc').show().focus();
    });

    $('.popover-sr-end-button').focus(function(){
      $(this).prev('.popover-sr-desc').hide();
      $(this).blur();
    });
  });


  // Ajuste acessibilidade slider
  $('.unslider-arrow').each(function(){
    $(this).attr('aria-hidden','true');
  });

  $('.unslider-nav').each(function(){
    $(this).attr('aria-hidden','true');
  });


  //aplica cor do curso
  //$('body').addClass('disciplina-gestao');
  //$('body').addClass('disciplina-conselhos');
  //$('body').addClass('disciplina-infantil');
  //$('body').addClass('disciplina-fundamental');
  //$('body').addClass('disciplina-linguagens');
  //$('body').addClass('disciplina-ingles');
  //$('body').addClass('disciplina-edfisica');
  //$('body').addClass('disciplina-arte');
  //$('body').addClass('disciplina-matematica');
  //$('body').addClass('disciplina-historia');
  //$('body').addClass('disciplina-geografia');
  //$('body').addClass('disciplina-ciencias');
  //$('body').addClass('disciplina-religiao');
  //$('body').addClass('disciplina-humanas');
  //$('body').addClass('disciplina-natureza');
});





