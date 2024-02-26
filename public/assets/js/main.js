$.noConflict();

jQuery(document).ready(function($) {
    "use strict";

    [].slice
        .call(document.querySelectorAll("select.cs-select"))
        .forEach(function(el) {
            new SelectFx(el);
        });

    jQuery(".selectpicker").selectpicker;

    $(".search-trigger").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(".search-trigger").parent(".header-left").addClass("open");
    });

    $(".search-close").on("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(".search-trigger").parent(".header-left").removeClass("open");
    });

    $(".equal-height").matchHeight({
        property: "max-height",
    });

    // var chartsheight = $('.flotRealtime2').height();
    // $('.traffic-chart').css('height', chartsheight-122);

    // Counter Number
    $(".count").each(function() {
        $(this)
            .prop("Counter", 0)
            .animate({
                Counter: $(this).text(),
            }, {
                duration: 3000,
                easing: "swing",
                step: function(now) {
                    $(this).text(Math.ceil(now));
                },
            });
    });

    // Menu Trigger
    $("#menuToggle").on("click", function(event) {
        var windowWidth = $(window).width();
        if (windowWidth < 1010) {
            $("body").removeClass("open");
            if (windowWidth < 760) {
                $("#left-panel").slideToggle();
            } else {
                $("#left-panel").toggleClass("open-menu");
            }
        } else {
            $("body").toggleClass("open");
            $("#left-panel").removeClass("open-menu");
        }
    });
    $(".menu-item-has-children.dropdown").each(function() {
        $(this).on("click", function() {
            var $temp_text = $(this).children(".dropdown-toggle").html();
            $(this)
                .children(".sub-menu")
                .prepend('<li class="subtitle">' + $temp_text + "</li>");
        });
    });
    // Load Resize
    $(window).on("load resize", function(event) {
        var windowWidth = $(window).width();
        if (windowWidth < 1010) {
            $("body").addClass("small-device");
        } else {
            $("body").removeClass("small-device");
        }
    });

    /**
     *
     * start coding for custom script
     *
     */
    $(".add-new-photo").on("click", function() {
        let html = `<div class="list-group-item">
                                       <div class=" d-flex align-items-center">
                                        <input type="file" name="image[]" required id="image" class="form-control mr-1" />
                                        <div class="photo__trash bg-danger text-white p-2"><i class="fa fa-trash"></i></div>
                                       </div>
                                    </div>`;
        $(".photos .list-group").append(html);
    });
    $(".update-new-photo").on("click", function() {
        let element = $(".list-group-img").children();
        let html = `<div class="list-group-item">
                                       <div class=" d-flex align-items-center">
                                        <input type="file" name="image[${
                                            Array.from(element).length
                                        }][img]" required id="image" class="form-control mr-1" />
                                        <div class="photo__trash bg-danger text-white p-2"><i class="fa fa-trash"></i></div>
                                       </div>
                                    </div>`;
        $(".photos .list-group").append(html);
    });
    $(document).on("click", ".photos  .photo__trash", function() {
        $(this).closest(".photos  .list-group-item").remove();
    });
    $(".add-new-feature").on("click", function() {
        let html = `<div class="list-group-item d-flex align-items-center">
				 	<div class="px-1 w-100"><input type="text" name="feature[]"  placeholder="Feature details"  class="form-control"></div>
					<div class="feature__trash bg-danger text-white p-2"><i class="fa fa-trash"></i></div>
				</div>`;
        $(".feature .list-group").append(html);
    });
    $(document).on("click", ".feature  .feature__trash", function() {
        $(this).closest(".feature  .list-group-item").remove();
    });

    $(document).on("click", ".add-new-question", function() {
        let element = $(".list-group-main").children();
        let html = `<div class="list-group-item d-flex align-items-center list--group-main">
                        <div class="pr-2" style="flex: 1">
                                <div class="py-1">
                                            <div class="d-flex">
                                                <input type="text" required name="question_title[][title]" placeholder="Question title" class="form-control">
                                                <button type="button" class="btn btn-sm btn-success ml-2 add_question_option"><i class="fa fa-plus"></i></button>
                                            </div>
                                            <div class="list-group list-group-sub" data-main-id="${
                                                Array.from(element).length
                                            }">
                                                <div class="list-group-item d-flex align-items-center mt-2">
                                                    <div class="pr-2" style="flex: 1">
                                                        <div class="py-1">
                                                            <input type="text" required name="question_title[${
                                                                Array.from(
                                                                    element
                                                                ).length
                                                            }][0][option]" placeholder="Write option" class="form-control">
                                                            <input type="number" required name="question_title[${
                                                                Array.from(
                                                                    element
                                                                ).length
                                                            }][0][price]" placeholder="Price" class="form-control mt-1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        </div>
                        <div class="question__trash bg-danger text-white p-2"><i class="fa fa-trash"></i></div>
                    </div>`;
        $(".service-question .list-group-main").append(html);
    });
    $(document).on("click", ".service-question .question__trash", function() {
        $(this).closest(".service-question .list-group-item").remove();
    });
    $(document).on("click", ".add_question_option", function() {
        let element = $(this)
            .closest(".list--group-main")
            .find(".list-group-sub")
            .children();
        let list_main = $(this)
            .closest(".list--group-main")
            .find(".list-group-sub")
            .attr("data-main-id");
        let html = `<div class="list-group-item d-flex align-items-center mt-2">
                        <div class="pr-2" style="flex: 1">
                            <div class="py-1">
                                <input type="text" required name="question_title[${list_main}][${
            Array.from(element).length
        }][option]" placeholder="Write option" class="form-control">
                                <input type="text" required name="question_title[${list_main}][${
            Array.from(element).length
        }][price]" placeholder="Price" class="form-control mt-1">
                             </div>
                        </div>
<div class="question_option__trash bg-danger text-white p-2"><i class="fa fa-trash"></i></div>
                    </div>`;
        $(this)
            .closest(".list--group-main")
            .find(".list-group-sub")
            .append(html);
    });
    $(document).on(
        "click",
        ".service-question .question_option__trash",
        function() {
            let question_option_id = $(this)
                .closest(".service-question .list-group-sub .list-group-item")
                .find(".question_option_id")
                .val();

            if (question_option_id) {
                $(".option_id_put").append(
                    `<input type="hidden" name="option_delete_ids[]" value="${question_option_id}" class="option_delete_ids">`
                );
            }
            $(this)
                .closest(".service-question .list-group-sub .list-group-item")
                .remove();
        }
    );
    $(".select_img").change(function(e) {
        $(this).next().val($(this).attr("data-id"));
    });
});