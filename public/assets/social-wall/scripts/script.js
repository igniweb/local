'use strict';

// Check instance
if (typeof local == 'undefined' || ! local) {
    var local = {};
}
if (typeof local.SocialWall == 'undefined' || ! local.SocialWall) {
    local.SocialWall = {};
}
local.SocialWall.Main = function() {
    this.init();
}

// Prototype
local.SocialWall.Main.prototype = {

    $header:   null,
    $nav:      null,
    $content:  null,
    $top:      null,
    navY:      null,
    isFixed:   null,
    scrollTop: null,

    init: function() {
        // Bind events
        jQuery(document).ready(jQuery.proxy(this, 'onDocumentReady'));
        jQuery(window).scroll(jQuery.proxy(this, 'onWindowScroll'));
        jQuery(window).resize(jQuery.proxy(this, 'onWindowResize'));
    },

    onDocumentReady: function() {
        this.$header  = jQuery('#header');
        this.$nav     = jQuery('nav#primary');
        this.$content = jQuery('#content');
        this.navY     = this.$nav.offset().top;
        this.isFixed  = false;

        this.$top = jQuery('#top');
        this.$top.hide();
    },

    onWindowScroll: function() {
        this.scrollTop = jQuery(window).scrollTop();

        this.handleTopLink();
        this.handleStickyNav();
        this.handleParallaxHeader();
    },

    onWindowResize: function() {
        this.ensureFullWidthNav();
    },

    handleTopLink: function() {
        if (this.scrollTop >= 600) {
            this.$top.fadeIn(500);
        } else {
            this.$top.fadeOut(500);
        }
    },

    handleStickyNav: function() {
        var shouldBeFixed = this.scrollTop > this.navY;
        if (shouldBeFixed && ! isFixed) {
            this.$nav.css({
                position: 'fixed',
                width:    '100%',
                top:      0,
                opacity:  0.9
            });

            this.$content.css({
                paddingTop: '75px'
            });

            this.isFixed = true;
        } else if ( ! shouldBeFixed && isFixed) {
            this.$nav.css({
                position: 'relative',
                width:    '100%',
                opacity:  1
            });

            this.$content.css({
                paddingTop: '0'
            });

            isFixed = false;
        }
    },

    handleParallaxHeader: function() {
        var slowScroll = this.scrollTop / 2;
        this.$header.css({ transform: 'translateY(' + slowScroll + 'px)' });
    },

    ensureFullWidthNav: function() {
        this.$nav.css({ width: '100%' });
    }

};

// Run instance
var localSocialWall = new local.SocialWall.Main();
