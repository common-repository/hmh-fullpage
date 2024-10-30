(function($) {
    'use strict';
    
    $(document).ready(function() {
        $('.bb-button-delete2').live('click', function(){
            var $self = $(this),
                id = $self.data('id'),
                $table = $self.closest('table').DataTable(),
                $row = $self.closest('tr');
                
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Header!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDelete){
                
                if (willDelete) {
                    $('.bb-ajax-loading').css({display: 'flex'});
                    $.post(ajaxurl, { 'action': 'Bbfp_delete_header', id: id }, function(response) {
                        
                        response = JSON.parse(response);
                        if(typeof response.status != 'undefined') {
                            $.growl({ title: response.title, message: response.message, location: 'br', style: response.status });
                            
                            if(response.status == 'notice') {
                                $table.row($row).remove();
                                $table.draw();
                            }
                        }
                        
                        $('.bb-ajax-loading').css({display: 'none'});
                        
                    });
                }
            });
            return;
        });
    });
    
}(window.jQuery));