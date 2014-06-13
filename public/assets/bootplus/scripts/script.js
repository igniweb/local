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

    firstTrig:  true,
    isLoading:  false,
    masonryId:  null,
    socialWall: null,

    init: function() {
        // Bind events
        jQuery(document).ready(jQuery.proxy(this, 'onDocumentReady'));
        jQuery(window).scroll(jQuery.proxy(this, 'onWindowScroll'));        
    },

    onDocumentReady: function() {
        this.masonryId = 'masonry';
        this.initMasonry();
    },

    onWindowResize: function() {
        this.setScrollLim();
    },

    onWindowScroll: function() {
        if ((window.innerHeight + window.scrollY + 50) >= document.body.offsetHeight) {
            if ( ! this.isLoading && ! this.firstTrig) {
                this.handleInfiniteScroll();
            }
        }
        this.firstTrig = false;
    },

    handleInfiniteScroll: function() {
        this.isLoading = true;
        console.log('handleInfiniteScroll');
        this.isLoading = false;
    },

    initMasonry: function() {
        jQuery('#' + this.masonryId).hide();

        this.socialWall = new Masonry('#' + this.masonryId, {
            columnWidth:  180,
            gutter:       1,
            itemSelector: '.item'
        });
        imagesLoaded('#' + this.masonryId, jQuery.proxy(this, 'layoutMasonry'));
    },

    layoutMasonry: function() {
        jQuery('#' + this.masonryId + '_loader').hide();
        jQuery('#' + this.masonryId).show();

        this.socialWall.layout();
    }

};

// Run instance
var localSocialWall = new local.SocialWall.Main();
