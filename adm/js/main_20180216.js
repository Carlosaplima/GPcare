$(document).ready(function(){$("button").click(function(){id=$(this).attr("id");$(".description").addClass("none");$("#description"+id).removeClass("none").addClass("block");$(".image").addClass("none");$("#img"+id).removeClass("none").addClass("block")})});

$(".incr-btn").on("click",function(a){var c=$(this),b=c.parent().find(".quantity").val();c.parent().find('.incr-btn[data-action="decrease"]').removeClass("inactive");"increase"==c.data("action")?b=parseFloat(b)+1:1<b?b=parseFloat(b)-1:(b=1,c.addClass("inactive"));c.parent().find(".quantity").val(b);a.preventDefault()});

$(".incr-btn-line").on("click",function(a){var c=$(this),b=c.parent().find(".quantity-line").val();c.parent().find('.incr-btn-line[data-action="decrease-line"]').removeClass("inactive");"increase-line"==c.data("action")?b=parseFloat(b)+1:1<b?b=parseFloat(b)-1:(b=1,c.addClass("inactive"));c.parent().find(".quantity-line").val(b);a.preventDefault()});

$(document).ready(function(){$("#zoom_03").elevateZoom({gallery:"gallery_01",cursor:"pointer",galleryActiveClass:"active",imageCrossfade:!0,loadingIcon:"http://www.elevateweb.co.uk/spinner.gif"});$("#zoom_03").bind("click",function(a){a=$("#zoom_03").data("elevateZoom");a.closeAll();$.fancybox(a.getGalleryList());return!1})});var map;

function initMap(){map=new google.maps.Map(document.getElementById("map"),{center:{lat:-23.4955641,lng:-46.6056149},zoom:18,scrollwheel:!1});var a=new google.maps.Marker({map:map,place:{location:{lat:-23.4955641,lng:-46.6056149},query:"Google, São Paulo, Brasil"},attribution:{source:"Google Maps JavaScript API",webUrl:"https://developers.google.com/maps/"}}),c=new google.maps.InfoWindow;google.maps.event.addListener(a,"click",function(a,d){return function(){c.setContent("BicDados Coleta de Dados e Automação <br> R. Quedas, 486 - Vila Isolina Mazzei<br> São Paulo - SP 02082-030 Brasil");

c.open(map,a)}}(a))}jQuery("document").ready(function(a){var c=a(".cont-lcz-bsc");a(window).scroll(function(){259<a(this).scrollTop()?c.addClass("fixa-menu"):c.removeClass("fixa-menu")});$(document).ready(function(){$("#SelectOptions").on("change",function(){var a="."+$(this).val();$(".cont-form div").hide();$(a).toggle()})});$("#myCarouselpq").carousel({interval:1E4});

$(".style-carousel .item").each(function(){var a=$(this).next();a.length||(a=$(this).siblings(":first"));a.children(":first-child").clone().appendTo($(this));0<a.next().length?a.next().children(":first-child").clone().appendTo($(this)):$(this).siblings(":first").children(":first-child").clone().appendTo($(this))});





var banner = $('.cont-banner');

$(window).scroll(function () {

    if ($(this).scrollTop() > 259) {

        banner.addClass("padding-top-menu");} 

        else {banner.removeClass("padding-top-menu");

    }});



var atfixo = $('.cont-box');

$(window).scroll(function () {

    if ($(this).scrollTop() > 300) {

        atfixo.addClass("style-at-online");} 

        else {atfixo.removeClass("style-at-online");

    }});









});













 $(document).ready(function() {

    $('#contact_form').bootstrapValidator({



        feedbackIcons: {

            valid: 'glyphicon glyphicon-ok',

            invalid: 'glyphicon glyphicon-remove',

            validating: 'glyphicon glyphicon-refresh'

        },

        fields: {

            name: {

                validators: {

                        stringLength: {

                        min: 2,

                        message: 'Digite seu nome'

                    },

                        notEmpty: {

                        message: 'Digite um nome válido'

                    }

                }

            },

                        prd: {

                validators: {

                        stringLength: {

                        min: 2,

                        message: 'Digite seu produto'

                    },

                        notEmpty: {

                        message: 'Digite um produto válido'

                    }

                }

            },

            email: {

                validators: {

                    notEmpty: {

                        message: 'Digite seu e-mail'

                    },

                    emailAddress: {

                        message: 'Digite um e-mail válido'

                    }

                }

            },

            phone: {

                validators: {

                    notEmpty: {

                        message: 'Digite seu telefone'

                    },

              

                        regexp: {

regexp:/^1\d\d(\d\d)?$|^0800 ?\d{3} ?\d{4}$|^(\(0?([1-9a-zA-Z][0-9a-zA-Z])?[1-9]\d\) ?|0?([1-9a-zA-Z][0-9a-zA-Z])?[1-9]\d[ .-]?)?(9|9[ .-])?[2-9]\d{3}[ .-]?\d{4}$/,





                        message: 'Digite um número de Telefone'

                   

                }

            }

        },



                cpf: {

                    validators: {

                        notEmpty: {

                            message: 'Digite CPF ou CNPJ'

                        },

                        regexp: {

                            //regexp: /^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$/,



regexp:/^([0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}|[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2})$/,





                            message: 'Formato invalido'

                        }

                    }

                },

    





            comment: {

                validators: {

                      stringLength: {

                        min: 10,

                        max: 200,

                        message:'Minimo de caracteres 10, máximo 200'

                    },

                    notEmpty: {

                        message: 'Digite sua dúvida'

                    }

                    }

                }

            }

        })





        .on('success.form.bv', function(e) {

            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...

                $('#contact_form').data('bootstrapValidator').resetForm();



            // Prevent form submission

            e.preventDefault();



            // Get the form instance

            var $form = $(e.target);



            // Get the BootstrapValidator instance

            var bv = $form.data('bootstrapValidator');



            // Use Ajax to submit form data

            $.post($form.attr('action'), $form.serialize(), function(result) {

                console.log(result);

            }, 'json');

        });

});









jQuery(document).ready(function($) {

   $.easing.easeInOutExpo = function (x, t, b, c, d) { // definição do efeito que será posteriormente usado no animate

      if (t==0) return b;

      if (t==d) return b+c;

      if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;

      return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;

   }



   $(".scroll").click(function(event){

      event.preventDefault();

      $('html,body').animate({

         scrollTop:$(this.hash).offset().top

      }, {

         duration: 3000,

         easing: 'easeInOutExpo' // basta usar o mesmo nome que você definiu acima ;)

      });

   });

});





$( ".box-bt-atd" ).click(function() {

  $( ".container-atd-online" ).toggleClass( "efeito-atd-online" );

});



$(document).ready(function(){

  $('#bt-efeito-atd').click(function(){

    $(this).toggleClass('open');

  });

});



    $(document).ready(function(e) {

        $('.containerx').isotope();

    });     





$(window).on("load", function (e) {

 $(".loader").fadeOut("slow"); //retire o delay quando for copiar!

    $("#tudo_page").toggle("fast");

});



