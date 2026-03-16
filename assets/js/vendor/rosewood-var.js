var WP = WP || {},
    $ = jQuery;

// Cache window and calculate viewport bounds
var $window = $(window);
var viewportBounds = {
    top: $window.scrollTop(),
    bottom: $window.scrollTop() + $window.height()
};

WP.mobileMenu = {
    init: function () {
        $(".nav-toggle").on("click", function () {
            $(this).toggleClass("active");
            $(".mobile-menu-wrapper").slideToggle().toggleClass("visible");
            $("body").toggleClass("mobile-menu-visible lock-scroll");
            $(".mobile-search, .toggle-mobile-search").removeClass("active");
        });

        $window.on("resize", function () {
            if ($window.width() > 1000) {
                $("body").removeClass("mobile-menu-visible lock-scroll");
                $(".mobile-menu-wrapper").hide().removeClass("visible");
                $(".nav-toggle").removeClass("active");
                $(".mobile-search").removeClass("active hide");
                WP.ajaxSearch.emptyResults();
            }
        });
    }
};

WP.searchToggle = {
    init: function () {
        $('a[href$="?s="]').on("click", function () {
            $(this).toggleClass("active");
            $(".search-overlay").toggleClass("active");
            if ($(this).hasClass("active")) {
                $(".search-overlay .search-field").focus();
            } else {
                $(".search-overlay .search-field").blur();
            }
            return false;
        });

        $(".search-overlay").on("click", function (e) {
            if (e.target === this) {
                $(".search-overlay .search-field").blur();
                $(".search-overlay").removeClass("active");
                $('.social-menu.desktop a[href$="?s="]').removeClass("active");
            }
        });

        $(".toggle-mobile-search").on("click", function () {
            $(".mobile-search").removeClass("hide");
            $(".toggle-mobile-search, .mobile-search").toggleClass("active");
            $(".mobile-search .search-field").focus();
            return false;
        });

        $(".untoggle-mobile-search").on("click", function () {
            $(".mobile-search").addClass("hide");
            $(".mobile-search, .toggle-mobile-search").removeClass("active");
            $(".mobile-search .search-field").blur();
            WP.ajaxSearch.emptyResults();
            return false;
        });
    }
};

WP.intrinsicRatioEmbeds = {
    init: function () {
        var selector = ".post iframe, .post object, .post video, .widget-content iframe, .widget-content object, .widget-content video";

        var resizeEmbeds = function (selector) {
            $(selector).each(function () {
                var $el = $(this),
                    $parent = $el.parent(),
                    containerWidth = $parent.width();

                if (!$el.attr("data-origwidth")) {
                    $el.attr("data-origwidth", $el.attr("width"));
                    $el.attr("data-origheight", $el.attr("height"));
                }

                var ratio = containerWidth / $el.attr("data-origwidth");
                $el.css("width", containerWidth + "px");
                $el.css("height", $el.attr("data-origheight") * ratio + "px");
            });
        };

        resizeEmbeds(selector);

        $window.on("resize", function () {
            resizeEmbeds(selector);
        });
    }
};

WP.smoothScroll = {
    init: function () {
        $('a[href*="#"]')
            .not('[href="#"]')
            .not('[href="#0"]')
            .not(".skip-link")
            .on("click", function (e) {
                if (
                    location.pathname.replace(/^\//, "") === this.pathname.replace(/^\//, "") &&
                    location.hostname === this.hostname
                ) {
                    var $target = $(this.hash);
                    $target = $target.length ? $target : $("[name=" + this.hash.slice(1) + "]");

                    if ($target.length) {
                        e.preventDefault();
                        $("html, body").animate({ scrollTop: $target.offset().top }, 1000);
                    }
                }
            });
    }
};

WP.ajaxSearch = {
    init: function () {
        // Debounce utility
        var debounce = (function () {
            var timer = 0;
            return function (callback, delay) {
                clearTimeout(timer);
                timer = setTimeout(callback, delay);
            };
        })();

        $(".mobile-search .search-field").on("keyup", function () {
            if ($(this).val().length !== 0) {
                debounce(function () { WP.ajaxSearch.loadPosts(); }, 200);
            } else {
                debounce(function () { WP.ajaxSearch.emptyResults(); }, 50);
            }
        });

        debounce(function () { WP.ajaxSearch.emptyResults(); }, 50);

        $(".mobile-search .search-field").on("blur", function () {
            if ($(this).val().length === 0) {
                WP.ajaxSearch.emptyResults();
            }
        });
    },

    loadPosts: function () {
        var $resultsWrapper = $(".mobile-results .results-wrapper"),
            searchValue = $(".mobile-search .search-field").val(),
            searchString = JSON.stringify(searchValue);

        $.ajax({
            url: mcluhan_ajaxpagination.ajaxurl,
            type: "POST",
            data: {
                action: "ajax_pagination",
                query_data: searchString
            },
            beforeSend: function () {
                $(".mobile-results").addClass("loading");
            },
            success: function (response) {
                $resultsWrapper.empty().append($(response));
                $(".mobile-results").addClass("searching");
                if (response.indexOf("no-results-message") >= 0) {
                    $(".mobile-results").addClass("no-results");
                } else {
                    $(".mobile-results").removeClass("no-results");
                }
            },
            complete: function () {
                $(".mobile-results").removeClass("loading");
            },
            error: function (xhr, status, error) {
                console.error("AJAX error: " + error);
            }
        });
    },

    emptyResults: function () {
        $(".mobile-results .results-wrapper").empty();
        $(".mobile-results").removeClass("no-results searching");
        $(".mobile-search .search-field").val("");
    }
};

$(document).ready(function () {
    WP.mobileMenu.init();
    WP.searchToggle.init();
    WP.intrinsicRatioEmbeds.init();
    WP.smoothScroll.init();
    WP.ajaxSearch.init();
});