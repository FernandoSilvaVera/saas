(function ($) {
    "use strict";

    // ------- Prealoder ------
    $(window).on('load', function () {
        $("#preloader").delay(300).fadeOut("slow");
    });


    // Handle Menu on Sreen scrolling
    function MenuOnScrol() {
        const elementToModify = document.querySelector(".site_header");
        let lastScrollTop = 0;
        window.addEventListener("scroll", () => {
            const scrollTop = window.scrollY || window.pageYOffset;
            if (scrollTop > lastScrollTop && lastScrollTop > 200) {
//                elementToModify.classList.add("sticky");
            } else if (lastScrollTop < 210) {
//                elementToModify.classList.remove("menu_up");
//                elementToModify.classList.remove("sticky");
            } else {
//                elementToModify.classList.remove("menu_up");
            }
            if (scrollTop > lastScrollTop) {
//                elementToModify.classList.add("menu_up");
            }
            lastScrollTop = scrollTop;
        });
    }


    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 600) {
            $('.back-to-top').addClass("topbtn_hide");
        } else {
            $('.back-to-top').removeClass("topbtn_hide");
        }
    });
    $('.back-to-top').on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: 0,
        }, 1500);


        // Menu Hide
        MenuOnScrol()
    });


    $(document).ready(function () {

        // header scroling
        MenuOnScrol()


        // Toggle Menu
        $('.hamburger').click(function (e) {
            $(this).addClass("active");

            $('.dashboard').toggleClass('sidebar_expanded');
        });

        // price section
        $('.price_tab').click(function (e) {
            var id = $(this).attr('id');

            if ($('.price_tabs').hasClass('monthly-tab')) {
                $('.price_tabs').removeClass('monthly-tab');
            } else if ($('.price_tabs').hasClass('yearly-tab')) {
                $('.price_tabs').removeClass('yearly-tab');
            }

            setTimeout(() => {
                $('.price_tabs').addClass(id);
            }, 50);
        });


        // overlay
        $('.overlay').click(function (e) {
            $('.hamburger').removeClass("active");
            $('.dashboard').removeClass('sidebar_expanded');
        });



        // show_hide
        $('.show_hide').click(function () {
            $(this).toggleClass("hide");

            var inputField = $(this).siblings('.input_field');
            var eyeUncut = $(this).find('.eye_uncut');
            var eyeCut = $(this).find('.eye_cut');

            if (inputField.attr('type') === 'password') {
                inputField.attr('type', 'text');
                eyeUncut.hide();
                eyeCut.show();
            } else {
                inputField.attr('type', 'password');
                eyeUncut.show();
                eyeCut.hide();
            }
        });






        // select_tab
        $('.select_tab').click(function (e) {
            var select_tab_text = $(this).html();

            $('.selected_text').html(select_tab_text);
            $('.app_top_select').removeClass('active');
        });

        $('.selected_tab').click(function (e) {
            $('.app_top_select').toggleClass('active');
        });


        // check_box
        $('.check_box').click(function (e) {
            $(this).toggleClass('active');
        });

        
        // Image Upload
        $("#file-input1").change(function () {
            var inputElement = this;
            var file = inputElement.files[0];
            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(inputElement).closest('.drop-container').find(".preview-image").attr("src", e.target.result);
                    $(inputElement).closest('.drop-container').find(".cross").css("display", "flex");
                    $(inputElement).closest('.drop-container').addClass("active");
                };
                reader.readAsDataURL(file);
            }
        });

        $(".preview-image").click(function (event) {
            event.preventDefault();
            $("#file-input1").click();
        });

        $(".cross").click(function () {
            $(this).closest('.drop-container').find("#file-input1").val("");
            $(this).closest('.drop-container').find(".preview-image").attr("src", "");
            $(this).css("display", "none");
            $(this).closest('.drop-container').removeClass("active");
        });


        // Image Upload
        $("#file-input2").change(function () {
            var inputElement = this;
            var file = inputElement.files[0];
            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(inputElement).closest('.drop-container').find(".preview-image").attr("src", e.target.result);
                    $(inputElement).closest('.drop-container').find(".cross").css("display", "flex");
                    $(inputElement).closest('.drop-container').addClass("active");
                };
                reader.readAsDataURL(file);
            }
        });

        $(".cross").click(function () {
            $(this).closest('.drop-container').find("#file-input2").val("");
            $(this).closest('.drop-container').find(".preview-image").attr("src", "");
            $(this).css("display", "none");
            $(this).closest('.drop-container').removeClass("active");
        })
	;
        $("#file-input3").change(function () {
            var inputElement = this;
            var file = inputElement.files[0];
            if (file) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(inputElement).closest('.drop-container').find(".preview-image").attr("src", e.target.result);
                    $(inputElement).closest('.drop-container').find(".cross").css("display", "flex");
                    $(inputElement).closest('.drop-container').addClass("active");
                };
                reader.readAsDataURL(file);
            }
        });

        $(".cross").click(function () {
            $(this).closest('.drop-container').find("#file-input3").val("");
            $(this).closest('.drop-container').find(".preview-image").attr("src", "");
            $(this).css("display", "none");
            $(this).closest('.drop-container').removeClass("active");
        });




    });

})(jQuery);
