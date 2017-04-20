baseurl = $('body').data('baseurl');
// var lang = new Lang();
//     //lang.loadPack('en');
//     lang.dynamic("es", baseurl+"assest/bootstrap/js/lenguaje/es.json");
//     lang.init({
//         currentLang:'es'
//     });
        // heigthZeo = $('.zeo-biografy').outerHeight();
        // alert('una vez '+heigthZeo);

        //$('.img-bios').css('height',heigthZeo+'px');

    $.fn.parallax = function(options) {
 
        var windowHeight = $(window).height();
 
        // Establish default settings
        var settings = $.extend({
            speed        : 0.15
        }, options);
 
        // Iterate over each object in collection
        return this.each( function() {
 
            // Save a reference to the element
            var $this = $(this);
 
            // Set up Scroll Handler
            $(document).scroll(function(){
 
                    var scrollTop = $(window).scrollTop();
                        var offset = $this.offset().top;
                        var height = $this.outerHeight();
 
            // Check if above or below viewport
            if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
                return;
            }
 
            var yBgPosition = Math.round((offset - scrollTop) * settings.speed);
 
                 // Apply the Y Background Position to Set the Parallax Effect
                $this.css('background-position', 'center ' + yBgPosition + 'px');
                
            });
        });
    }

jQuery(document).ready(function ($) {

    $('.quickflip-wrapper').hover(function(ev) {
        $(ev.target).quickFlipper();
    });

    $('.section-servicios').parallax({
        speed : 0.25
    });

    $('#porfolio').parallax({
        speed : 0.25
    });

    $('div#introZeo .carousel-inner .item:first-child').addClass('active');

    $('#carousel-porfolio .carousel-inner .item:first-child').addClass('active');

    // $("#introZeo").swiperight(function() {  
    //     $(this).carousel('prev');  
    // });  
    // $("#introZeo").swipeleft(function() {  
    //     $(this).carousel('next');  
    // });  

    $('#introZeo').carousel({
      interval: 10000
    });

    // //Enable swiping...
    // $(".carousel-inner").swipe( {
    //     //Generic swipe handler for all directions
    //     swipeLeft:function(event, direction, distance, duration, fingerCount) {
    //         $(this).parent().carousel('prev'); 
    //     },
    //     swipeRight: function() {
    //         $(this).parent().carousel('next'); 
    //     },
    //     //Default is 75px, set to 0 for demo so any distance triggers swipe
    //     threshold:0
    // });

    $('#imgservicio_2').hover(
        function(){
            $(this).attr('src',baseurl+'assest/img/ser_mobilgame2.png');
        },
        function(){
            $(this).attr('src',baseurl+'assest/img/ser_mobilgame.png');
        }
    );

    //heigthZeo = $('.zeo-biografy').outerHeight();
    //alert(heigthZeo);

    //$('.img-bios').css('height',heigthZeo+'px');


    idioma = $('body').data('langs');
    //alert(idioma);
    $('.menu-idioma li').each(function(){
        $(this).removeClass('active');
        idiomas = $(this).data('langs');
        if(idioma==idiomas){
            $(this).addClass('active');
        }
    });

    $('.menu-idioma li').click(function(){
                href = $(this).find('a').data('href');

                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:baseurl+'Zeopage/Lenguaje/langs',
                    data:{lang:href},
                    success:function(data){
                        //alert(location);
                        location.reload();
                        //alert(data.lang);
                    }
                });

    });

    $('.idioma-zeo-intro li').click(function(){
                href = $(this).find('a').data('href');
                //alert(href);
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:baseurl+'Zeopage/Lenguaje/langs',
                    data:{lang:href},
                    success:function(data){
                        //alert(location);
                        location.href = baseurl+'home';
                        //alert(data.lang);
                    }
                });

    });

    // $.ajax({
    //     type:"post",
    //     dataType:"json",
    //     url:'./tienda.php',
    //     data:null,
    //     success:function(data){
    //         $.each(data,function(index,value){
    //             alert('imagen -> '+value);
    //         });
            
    //     }
    // });

    var lastId,
    topMenu = $("#top-navigation"),
    topMenuHeight = topMenu.outerHeight(),
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function () {
            var href = $(this).attr("href");
            if(href.indexOf("#") === 0){
                var item = $($(this).attr("href"));
                if (item.length) {
                    return item;
                }
            }
        });

    $(".img-responsive").fadeIn(1500);

    //Animate contact form
    $('.job-row').on('inview', function (event, visible) {
        if (visible == true) {
            alert('ver');
            //jQuery(this).addClass("animated bounceIn");
        } else {
            alert('no ver');
            //jQuery(this).removeClass("animated bounceIn");
        }
    });


        if ($(this).scrollTop() > 130) {
            $('.navbar').addClass('navbar-fixed-top animated fadeInDown');
        } else {
            $('.navbar').removeClass('navbar-fixed-top animated fadeInDown');
        }

    // Bind to scroll
    $(window).scroll(function () {

        if ($(this).scrollTop() > 130) {
            $('.navbar').addClass('navbar-fixed-top animated fadeInDown');
        } else {
            $('.navbar').removeClass('navbar-fixed-top animated fadeInDown');
        }

        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight + 10;

        // Get id of current scroll item
        var cur = scrollItems.map(function () {
            if ($(this).offset().top < fromTop)
                return this;
        });

        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
            .parent().removeClass("active")
            .end().filter("[href=#" + id + "]").parent().addClass("active");
        }
    });



    $(window).load(function () {
        function filterPath(string) {
            return string.replace(/^\//, '').replace(/(index|default).[a-zA-Z]{3,4}$/, '').replace(/\/$/, '');
        }


        $('.navbar-nav-primary a').bind('click', function(event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: ($($anchor.attr('href')).offset().top-58)
            }, 1500, 'easeInOutExpo');
            event.preventDefault();
        });


        // $('.navbar-nav a[href*=#]').bind('click', function(event) {

        //     if (filterPath(location.pathname) == filterPath(this.pathname) && location.hostname == this.hostname && this.hash.replace(/#/, '')) {
        //         var $targetId = $(this.hash),
        //         $targetAnchor = $('[name=' + this.hash.slice(1) + ']');
        //         var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;

        //         if ($target) {

        //         //Hack collapse top navigation after clicking
        //         topMenu.parent().attr('style', 'height:0px').removeClass('in'); //Close navigation
        //         $('.navbar .btn-navbar').addClass('collapsed');

        //         var targetOffset = $target.offset().top - 53;

        //         var $anchor = $(this);
        //         $('html, body').stop().animate({
        //             scrollTop: targetOffset
        //         }, 1500, 'easeInOutExpo');

        //         event.preventDefault();

        //         }

        //     }

        // });

        // $('.navbar-nav a[href*=#]').each(function () {
        //     if (filterPath(location.pathname) == filterPath(this.pathname) && location.hostname == this.hostname && this.hash.replace(/#/, '')) {
        //         var $targetId = $(this.hash),
        //         $targetAnchor = $('[name=' + this.hash.slice(1) + ']');
        //         var $target = $targetId.length ? $targetId : $targetAnchor.length ? $targetAnchor : false;

        //         if ($target) {

        //             $(this).click(function () {

        //                 //Hack collapse top navigation after clicking
        //                 topMenu.parent().attr('style', 'height:0px').removeClass('in'); //Close navigation
        //                 $('.navbar .btn-navbar').addClass('collapsed');

        //                 var targetOffset = $target.offset().top - 63;
        //                 $('html, body').animate({
        //                     scrollTop: targetOffset
        //                 }, 800);
        //                 return false;
        //             });
        //         }
        //     }
        // });

    });

    $('.servicio_zeos').on('click',function(){
        numero = $(this).attr('id');
        $('select#select_servicio option:eq('+numero+')').prop('selected', true);
        $('html, body').animate({
            scrollTop: $('#contact').offset().top
        }, 1500, 'easeInOutExpo');
       // alert(select);
    });

    $('#submit-zeo').click(function(){
        var nombre = $('input#nombre-ser').val();
        var error = false;
        if(nombre == "" || nombre == " "){
            $('#err-nombre').show(500);
            $('#err-nombre').delay(2000);
            $('#err-nombre').animate({
                height: 'toggle'
            }, 500, function(){

            });
            error = true;
        }

        var select = $('select#select_servicio option:selected').attr('value');
        if(select == "" || select == " "){
            $('#err-select').show(500);
            $('#err-select').delay(2000);
            $('#err-select').animate({
                height: 'toggle'
            }, 500, function(){

            });
            error = true;
        }

        var emailCompare = /^([a-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,6})$/; // Syntax to compare against input
        var email = $('input#email-ser').val().toLowerCase();
        if(email == "" || email == " "){
            $('#err-email').html($('#err-email').text());
            $('#err-email').show(500);
            $('#err-email').delay(2000);
            $('#err-email').animate({
                height: 'toggle'
            }, 500, function(){

            });
            error = true;
        }  else if(!emailCompare.test(email)){
            $('#err-email').html($('#err-email').data('format-email'));
            $('#err-email').show(500);
            $('#err-email').delay(2000);
            $('#err-email').animate({
                height: 'toggle'
            }, 500, function(){

            });
            error = true;
        }

        var comment = $('textarea#comment-ser').val();
        if(comment == "" || comment == " "){
            $('#err-comment').show(500);
            $('#err-comment').delay(2000);
            $('#err-comment').animate({
                height: 'toggle'
            }, 500, function(){

            });
            error = true;
        }

        if(error==false){
            $.ajax({
                type:'post',
                dataType:'json',
                url:baseurl+'Zeopage/getEmail',
                data:$('#form-email-zeo').serialize(),
                success:function(data){
                    if(data.exito=='b'){
                        alert('se envio el mensaje');
                    } else if(data.exito=='e'){
                        alert('no se envio el mensaje');
                    }
                }
            });
        }
        return false;
    });



// var $animation_elements = $('.section-dividers');
// var $window = $(window);

// function check_if_in_view() {
//   var window_height = $window.height();
//   var window_top_position = $window.scrollTop();
//   var window_bottom_position = (window_top_position + window_height);

//   $.each($animation_elements, function() {
//     var $element = $(this);
//     var element_height = $element.outerHeight();
//     var element_top_position = $element.offset().top;
//     var element_bottom_position = (element_top_position + element_height);

//     //check to see if this current container is within viewport
//     if ((element_bottom_position >= window_top_position) &&
//       (element_top_position <= window_bottom_position)) {
//       $element.addClass('animated fadeIn');
//     } else {
//       $element.removeClass('animated fadeIn');
//     }
//   });
// }

// $window.on('scroll resize', check_if_in_view);
// $window.trigger('scroll');


});