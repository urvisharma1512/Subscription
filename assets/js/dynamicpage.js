jQuery(function() {

    var newHash = "",
        jQuerymainContent = jQuery("#main-content"),
        jQuerypageWrap = jQuery("#page-wrap"),
        baseHeight = 0,
        jQueryel;

    jQuerypageWrap.height(jQuerypageWrap.height());
    baseHeight = jQuerypageWrap.height() - jQuerymainContent.height();

    jQuery("nav").delegate("a", "click", function() {
        window.location.hash = jQuery(this).attr("href");
        return false;
    });

    jQuery(window).bind('hashchange', function() {

        newHash = window.location.hash.substring(1);

        if (newHash) {
            jQuerymainContent
                .find("#guts")
                .fadeOut(200, function() {
                    jQuerymainContent.hide().load(newHash + " #guts", function() {
                        jQuerymainContent.fadeIn(200, function() {
                            jQuerypageWrap.animate({
                                height: baseHeight + jQuerymainContent.height() + "px"
                            });
                        });
                        jQuery("nav a").removeClass("current");
                        jQuery("nav a[href=" + newHash + "]").addClass("current");
                    });
                });
        };

    });

    jQuery(window).trigger('hashchange');

});