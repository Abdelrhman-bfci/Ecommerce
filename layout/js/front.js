  $(document).ready(function() {

       'use strict';


    $("select").selectBoxIt({
      autoWidth:false
    });

    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="astrais">*</div>');
        }
    });


     $('.confirm').click(function(){

       return confirm('You Are Sure?');

     });

  $('[placeholder]').focus(function(){

      var data = $(this).attr('placeholder');
      $(this).attr('data',data).attr('placeholder','');

  });
  $('[placeholder]').blur(function(){

      var data = $(this).attr('data');
      $(this).attr('placeholder',data).removeAttr('data');

  });

     $('.fa-eye').hover(function(){
       $('.show').attr('type','text');
     },function(){
       $('.show').attr('type','password');
     });

     $('.login-page h1 span').click(function(){

        $(this).addClass('selected').siblings().removeClass('selected');

        $('.login-page form').slideUp(300);

        $('.'+$(this).data('class')).slideDown(300);


     });

     $('.live-name').keyup(function(){

        $('.live-preview .caption h3').text($(this).val());
     });

     $('.live-price').keyup(function(){

        $('.live-preview span').text("$"+$(this).val());
     });

     $('.live-desc').keyup(function(){

        $('.live-preview .caption p').text($(this).val());
     });


});
