(function() {
    var mobileMenuOutsideClick = function() {
        $(document).click(function(e) {
            var container = $("#m-header, .js-m-toggle");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                if ($("body").hasClass("offcanvas-visible")) {
                    $("body").removeClass("offcanvas-visible");
                    $(".js-m-toggle").removeClass("active")
                }
            }
        })
    };
    var offcanvasMenu = function() {
        $("body").prepend('<div id="m-header" />');
        $("body #pc-header .navbar").prepend('<a href="#" class="js-m-toggle m-toggle"><i></i></a>');
        $("#m-header").append($("#pc-header .nav").clone())
    };
    var burgerMenu = function() {
        $("body").on("click", ".js-m-toggle", function(event) {
            var $this = $(this);
            $("body").toggleClass("fh5co-overflow offcanvas-visible");
            $this.toggleClass("active");
            event.preventDefault()
        });
        $(window).resize(function() {
            if ($("body").hasClass("offcanvas-visible")) {
                $("body").removeClass("offcanvas-visible");
                $(".js-m-toggle").removeClass("active")
            }
        });
        $(window).scroll(function() {
            if ($("body").hasClass("offcanvas-visible")) {
                $("body").removeClass("offcanvas-visible");
                $(".js-m-toggle").removeClass("active")
            }
        })
    };
    var mobileClickMenu = function() {
        $("#m-header .nav li a").live("click", function() {
            if ($(this).next().is("ul")) {
                $(this).next("ul").css("display", "none");
                if ($(this).next("ul").css("display") == "none") {
                    $(this).next("ul").show();
                    $(this).find("span").removeClass("downward");
                    $(this).find("span").addClass("upward");
                    return false
                } else {
                    $(this).next("ul").hide();
                    $(this).next("ul").find("ul").slideUp();
                    $(this).find("i").attr("class", "touch-arrow-down");
                    $(this).find("span").removeClass("upward");
                    $(this).find("span").addClass("downward");
                    return false
                }
            }
        })
    };
    $(function() {
        mobileMenuOutsideClick();
        offcanvasMenu();
        burgerMenu()
    })
}());
