(function($) {
    'use strict';
        
    $('document').ready(function() {
        $( ".bbfp-fullpage" ).each(function() {
            var id = $(this).attr('id');
            console.log(id);
            var config = $(this).attr('data-fullpage');
            console.log(config);
            var myFullpage = new fullpage('#'+id, JSON.parse(config));
        });
    });
    

})(jQuery);