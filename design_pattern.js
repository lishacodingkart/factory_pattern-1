jQuery(function($){
$('#factory_data').click(function(e){
          e.preventDefault();
 $( ".containerData" ).empty();
             var factory_type = $('#factory_type').val(); 
             var quantity     = $('#quantity').val(); 
             if(quantity=="" || quantity<=100){
             alert("Quantity must be greater than 100 kg");
             return false;
             }else{
             var ajaxdata     = {
                               'action' :'factroyData',
                                'factory_type': factory_type,
                                'quantity': quantity
                                }
            $.ajax({
                  url: ajax_object.ajaxurl,
                  type:'POST',
                  data: ajaxdata,
                  success: function(result){
                    $( ".containerData" ).append(result);
                    return false;
                   // alert(result);
                  }
             });
          }
      });      
});
