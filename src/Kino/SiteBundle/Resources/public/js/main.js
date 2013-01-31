/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function getDateFunc(){
        var SortField = ( $('#SortField').val()!='' ? '&SortField='+$('#SortField').val() : ''  );
        var SortOrder = ( $('#SortOrder').val()!='' ? '&SortOrder='+$('#SortOrder').val() : ''  );
        $.ajax({
                   type: "POST",
                   url: "/ajax/refresh",
                   data: "GetDates=" + $('#GetDates').val() + SortField + SortOrder
                            
//                         + "&SortField=name&SortOrder=asc"
                         ,
                   success: function(msg){
                         $('#films').html(msg);
                         
                         $('.sort img').each( function(){
                             if ($(this).attr('src').indexOf('_gray')==-1) {
                                 $(this).attr('src', $(this).attr('src').replace('.png', '_gray.png'));
                             }
                         });
                         //alert( $('.' + $('#SortField').val() + ' .sort.' + $('#SortOrder').val() + ' img').attr('src') );
                         var newsrc = $('.' + $('#SortField').val() + ' .sort.' + $('#SortOrder').val() + ' img').attr('src').replace('_gray', '');
                         $('.' + $('#SortField').val() + ' .sort.' + $('#SortOrder').val() + ' img').attr('src', newsrc);
                   }
                 });			
}


$(function () {
          $('a.gallery').fancybox({
                                                          'autoScale'  : false,
                                                          'nextEffect' : 'fade',
                                                          'prevEffect' : 'fade',
                                                          'nextSpeed'  :  1000,
                                                          'prevSpeed'  :  1000
                                                          });
          $("#GetDates").datepicker({
                  dateFormat : 'yy-mm-dd',
                  onSelect : function() {
                          getDateFunc();
                  }
          });

          $(".films.head .sort").click( function() {
              $("#SortField").val(($('img',this).attr('src').indexOf('_gray')==-1 ? '' : $(this).parent().attr('sort')));
              $("#SortOrder").val(($('img',this).attr('src').indexOf('_gray')==-1 ? '' : $(this).attr('tp')));
              getDateFunc();
              return false;
          });

  });

