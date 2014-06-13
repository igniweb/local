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

    masonryId:  null,
    socialWall: null,

    init: function() {
        // Bind events
        jQuery(document).ready(jQuery.proxy(this, 'onDocumentReady'));
    },

    onDocumentReady: function() {
        this.masonryId = 'masonry';
        this.initMasonry();
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
