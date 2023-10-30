jQuery(window).load(function(){

    jQuery('#accordion-section-maiscode_theme_login_options').click(function(event) {
        // Hard coded URL for testing purposes
        wp.customize.previewer.previewUrl('http://dev.maiscode.com.br/wordpresstheme/wp-admin');
        wp.customize.previewer.refresh();
    });

    jQuery('#accordion-section-maiscode_theme_404_options').click(function(event) {
        // Hard coded URL for testing purposes
        wp.customize.previewer.previewUrl('../404error');
        wp.customize.previewer.refresh();
    });

    jQuery('#accordion-section-maiscode_theme_search_options').click(function(event) {
        // Hard coded URL for testing purposes
        wp.customize.previewer.previewUrl('../index');
        wp.customize.previewer.refresh();
    });

});