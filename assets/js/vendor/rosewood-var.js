//Namescape

var WP = WP || {},
    $ = jQuery;


// Theme Variables
var doc = $(document),
    win = $(window),
    winHeight = win.height(),
    windWidth = win.width();

    var viewport = {};
    viewport.top = $(window).scrollTop();
    viewport.bottom = viewport.top + $(window).height();