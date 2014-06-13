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

    $loaders:    null,
    $masonry:    null,
    isLoading:   null,
    firstScroll: null,

    init: function() {
        this.isLoading   = false;
        this.firstScroll = true;

        // Bind events
        jQuery(document).ready(jQuery.proxy(this, 'onDocumentReady'));
        jQuery(window).scroll(jQuery.proxy(this, 'onWindowScroll'));        
    },

    onDocumentReady: function() {
        this.$loaders = jQuery('.loader');
        this.$masonry = jQuery('#masonry');

        this.initMasonry();
    },

    onWindowScroll: function() {
        if ( ! this.firstScroll) {
            if ( ! this.isLoading) {
                if ((window.innerHeight + window.scrollY + 20) >= document.body.offsetHeight) {
                    this.handleInfiniteScroll();
                }
            }
        } else {
            this.firstScroll = false;
        }
    },

    initMasonry: function() {
        this.$masonry.masonry({
            columnWidth:  180,
            gutter:       5,
            itemSelector: '.item'
        });

        this.$masonry.imagesLoaded(jQuery.proxy(this, 'layoutMasonry'));
    },

    layoutMasonry: function() {
        this.$loaders.hide();

        this.$masonry.masonry('layout');
    },

    handleInfiniteScroll: function() {
        this.isLoading = true;
        this.$loaders.show();

        var offset = parseInt(this.$masonry.data('offset'));
        offset++;
        this.$masonry.data('offset', offset);
        
        jQuery.ajax({
            url:     '/social-wall/' + offset,
            type:    'GET',
            success: jQuery.proxy(this, 'addItems')
        });
    },

    addItems: function(items) {
        this.isLoading = false;

        this.$masonry.append(items);
        this.$masonry.masonry('reloadItems');

        this.$masonry.imagesLoaded(jQuery.proxy(this, 'layoutMasonry'));
    }

};

// Run instance
var localSocialWall = new local.SocialWall.Main();
