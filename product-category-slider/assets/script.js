jQuery(document).ready(function ($) {
    // Fetch slidesToShow values using AJAX
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        type: 'POST',
        data: {
            action: 'get_slider_settings'
        },
        success: function (response) {
            var sliderSettings = JSON.parse(response);

            console.log(sliderSettings);

            // Initialize Slick Slider with dynamically fetched slidesToShow values
            $('.category-slider').slick({
                slidesToShow: sliderSettings.slidesToShowDesktop,
                autoplay: false,
                autoplaySpeed: 2000,
                arrows: true,
                prevArrow: "<button type='button' class='slick-prev pull-left'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512'><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d='M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z'/></svg></i></button>",
                nextArrow: "<button type='button' class='slick-next pull-right'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512'><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d='M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z'/></svg></button>",
                responsive: [
                    {
                        breakpoint: sliderSettings.desktopBreakpoint,
                        settings: {
                            slidesToShow: sliderSettings.slidesToShowDesktop,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: sliderSettings.tabletBreakpoint,
                        settings: {
                            slidesToShow: sliderSettings.slidesToShowTablet,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: sliderSettings.mobileBreakpoint,
                        settings: {
                            slidesToShow: sliderSettings.slidesToShowMobile,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        }
    });
});
