jQuery(document).ready(function($) {

    function update_post_views(){
        var data = {
            'action': 'fast_affiliate_update_post_views',
            'post_id': $('#fa_post_id').attr('data-post_id'),
        };

        jQuery.post(ajax_object.ajax_url, data, function(response) {
        });
    }

    jQuery('.fa_product_footer').click(function(event){
        var elem = $(this);
        var link_id = elem.attr('data-link_id');

        var data = {
            'action': 'fast_affiliate_update_clicks',
            'source': 'footer',
            'link_id': link_id,
        };

        jQuery.post(ajax_object.ajax_url, data, function(response) {
        });
    });

    jQuery('.fa_product_widget').click(function(event){
        var elem = $(this);
        var link_id = elem.attr('data-link_id');

        var data = {
            'action': 'fast_affiliate_update_clicks',
            'source': 'widget',
            'link_id': link_id,
        };

        jQuery.post(ajax_object.ajax_url, data, function(response) {
        });
    });

    jQuery('.fa_product_shortcode').click(function(event){
        var elem = $(this);
        var link_id = elem.attr('data-link_id');

        var data = {
            'action': 'fast_affiliate_update_clicks',
            'source': 'shortcode',
            'link_id': link_id,
        };

        jQuery.post(ajax_object.ajax_url, data, function(response) {
        });
    });


    update_post_views();

    // function sticky_relocate() {
    //     var window_top = $(window).scrollTop();
    //     var div_top = $('#sticky-anchor').offset().top;
    //     var width = $('#fast_affiliate_widget2_product_sticky').width();
    //     var menu_item_height = 0;

    //     try {
    //         menu_item_height = $('.menu-item').height();
    //     }
    //     catch(err) {
    //     }

    //     if (window_top > div_top) {
    //         $('#fast_affiliate_widget2_product_sticky').addClass('stick');
    //         $('#fast_affiliate_widget2_product_sticky').width(width);
    //         $('#sticky-anchor').height($('#fast_affiliate_widget2_product_sticky').outerHeight());
    //         if (menu_item_height>0) {
    //             $("#fast_affiliate_widget2_product_sticky").css({top: menu_item_height});
    //         }
    //     } else {
    //         $('#fast_affiliate_widget2_product_sticky').removeClass('stick');
    //         $('#sticky-anchor').height(0);
    //     }
    // }

    // $(function() {
    //     if( $('#fast_affiliate_widget2_product_sticky').length ) {
    //         $(window).scroll(sticky_relocate);
    //         sticky_relocate();
    //     }
    // });

});