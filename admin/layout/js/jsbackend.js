  $(document).ready(function() {

       'use strict';

       $('.toggle-info').click(function(){
         $(this).toggleClass('selected').parent().next('.panel-body').slideToggle(700);

         if($(this).hasClass('selected')){
           $(this).html('<i class="fa fa-minus"></i>');
         }
         else {
           $(this).html('<i class="fa fa-plus"></i>');
         }
       });

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

     $('.fa-eye').hover(function(){
       $('.show').attr('type','text');
     },function(){
       $('.show').attr('type','password');
     });

     $('.cat h3').click(function(){

         $(this).next('.full-view').slideToggle(500);
     });

     $('.option span').click(function(){

       $(this).addClass('active').siblings('span').removeClass('active');

       if($(this).data('view') === 'full'){

         $('.cat .full-view').slideDown(500);
       }
       else {
          $('.cat .full-view').slideUp(500);
       }
     });

     $('.child-link').hover(function(){

       $('.show-delete').slideDown(1000);
     },
    function(){

       $('.show-delete').slideUp(1000);
     });
});
