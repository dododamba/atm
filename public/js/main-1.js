

/*======== Isotope Filter Script =========*/

    var mt_personal = window.mt_personal || {},
        $win = $(window);

        mt_personal.Isotope = function () {

        // 4 column layout
        var isotopeContainer = $(".isotopeContainer");
        if (!isotopeContainer.length || !jQuery().isotope) return;
        $win.on('load' , function(){
            isotopeContainer.isotope({
                itemSelector: ".isotopeSelector"
            });
            $(".mt_filter").on("click", "a", function (e) {
                $(".mt_filter ul li").find(".active").removeClass("active");
                $(this).addClass("active");
                var filterValue = $(this).attr("data-filter");
                isotopeContainer.isotope({ filter: filterValue });
                e.preventDefault();
            });
        });

    };

    mt_personal.Isotope();

    jQuery(window).on('load', function() {
    setTimeout(function() {
        jQuery('.bucket-list ul li:first-child a:first-child').trigger('click');
    },1000);
});

jQuery(document).on('click','.bucket-list .mt_filter ul li a', function(){
     jQuery(this).closest('ul').find('li').removeClass('active');
     jQuery(this).closest('li').addClass('active');
});