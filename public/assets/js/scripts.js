(function ($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/

    var preloader = $('#preloader');
    $(window).on('load', function () {
        setTimeout(function () {
            preloader.fadeOut('slow', function () {
                $(this).remove();
            });
        }, 300)
    });

    /*================================
    sidebar collapsing
    ==================================*/
    if (window.innerWidth <= 1364) {
        $('.page-container').addClass('sbar_collapsed');
    }
    $('.nav-btn').on('click', function () {
        $('.page-container').toggleClass('sbar_collapsed');
    });

    /*================================
    Start Footer resizer
    ==================================*/
    var e = function () {
        var e = (window.innerHeight > 0 ? window.innerHeight : this.screen.height) - 5;
        (e -= 67) < 1 && (e = 1), e > 67 && $(".main-content").css("min-height", e + "px")
    };
    $(window).ready(e), $(window).on("resize", e);

    /*================================
    sidebar menu
    ==================================*/
    $("#menu").metisMenu();

    /*================================
    slimscroll activation
    ==================================*/
    $('.menu-inner').slimScroll({
        height: 'auto'
    });
    $('.nofity-list').slimScroll({
        height: '435px'
    });
    $('.timeline-area').slimScroll({
        height: '500px'
    });
    $('.recent-activity').slimScroll({
        height: 'calc(100vh - 114px)'
    });
    $('.settings-list').slimScroll({
        height: 'calc(100vh - 158px)'
    });

    /*================================
    stickey Header
    ==================================*/
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();

        // console.log(mainHeader.innerHeight());
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });

    /*================================
    form bootstrap validation
    ==================================*/
    $('[data-toggle="popover"]').popover()

    /*------------- Start form Validation -------------*/
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);

    /*================================
    datatable active
    ==================================*/
    // if ($('#dataTable').length) {
    //     $('#dataTable').DataTable({
    //         "ajax": "data.json",
    //         responsive: true
    //     });
    // }
    // if ($('#dataTable2').length) {
    //     $('#dataTable2').DataTable({
    //         responsive: true
    //     });
    // }
    // if ($('#dataTable3').length) {
    //     $('#dataTable3').DataTable({
    //         responsive: true
    //     });
    // }


    /*================================
    Slicknav mobile menu
    ==================================*/
    $('ul#nav_menu').slicknav({
        prependTo: "#mobile_menu"
    });

    /*================================
    login form
    ==================================*/
    $('.form-gp input').on('focus', function () {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function () {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });

    /*================================
    slider-area background setting
    ==================================*/
    $('.settings-btn, .offset-close').on('click', function () {
        $('.offset-area').toggleClass('show_hide');
        $('.settings-btn').toggleClass('active');
    });

    /*================================
    Owl Carousel
    ==================================*/
    function slider_area() {
        var owl = $('.testimonial-carousel').owlCarousel({
            margin: 50,
            loop: true,
            autoplay: false,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                450: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 2
                },
                1360: {
                    items: 1
                },
                1600: {
                    items: 2
                }
            }
        });
    }

    slider_area();

    /*================================
    Fullscreen Page
    ==================================*/

    if ($('#full-view').length) {

        var requestFullscreen = function (ele) {
            if (ele.requestFullscreen) {
                ele.requestFullscreen();
            } else if (ele.webkitRequestFullscreen) {
                ele.webkitRequestFullscreen();
            } else if (ele.mozRequestFullScreen) {
                ele.mozRequestFullScreen();
            } else if (ele.msRequestFullscreen) {
                ele.msRequestFullscreen();
            } else {
                console.log('Fullscreen API is not supported.');
            }
        };

        var exitFullscreen = function () {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else {
                console.log('Fullscreen API is not supported.');
            }
        };

        var fsDocButton = document.getElementById('full-view');
        var fsExitDocButton = document.getElementById('full-view-exit');

        fsDocButton.addEventListener('click', function (e) {
            e.preventDefault();
            requestFullscreen(document.documentElement);
            $('body').addClass('expanded');
        });

        fsExitDocButton.addEventListener('click', function (e) {
            e.preventDefault();
            exitFullscreen();
            $('body').removeClass('expanded');
        });
    }


})(jQuery);

(function () {
    var Loading = function Loading() {
        this.el = false;
        this.add = function (el) {
            el.addClass('loading');
        }
        this.remove = function (el) {
            el.removeClass('loading');
        }
    };
    window.Loading = new Loading();
})(window);

function openCalculatorModal() {
    const amortize = 1,
          anuity = 2;
    const amortization = document.getElementById('amortization');
    const interestOnly = document.getElementById('interestOnly');
    const calculatorTable = document.getElementById('table');

    calculatorTable.innerHTML = '';

    let previousBalance = document.getElementById('amount').value;
    let currentRate = document.getElementById('rate').value;
    let currentTerm = document.getElementById('creditTime').value;
    let values = {};

    if (previousBalance === '' || currentRate === '' || currentTerm === ''){
        calculatorTable.innerHTML = '';
        return false;
    }

    values.jthAmount = parseInt(previousBalance);
    values.jthPercent = parseFloat(currentRate);
    values.jthTerms = (interestOnly.checked)?parseInt(amortization.value):parseInt(currentTerm);
    values.jthType = (interestOnly.checked)?anuity:amortize;

    if (values.jthType === 1) {
        let previousBalance = values.jthAmount;
        let paymentTotal = (values.jthAmount * (values.jthPercent / 100) / 12) / (1 - (1 / (Math.pow((1 + (values.jthPercent / 100) / 12), values.jthTerms))));

        for (let i = 1; i <= values.jthTerms; i++) {

            let paymentPercent = ((previousBalance * (values.jthPercent / 100)) / 12);
            let paymentBalance = (paymentTotal - paymentPercent);

            previousBalance = (previousBalance - paymentBalance);
            if (previousBalance < 0) {
                previousBalance = 0;
            }

            let currentPreviousBalance = numberFormat(previousBalance),
                currentPaymentPercent  = numberFormat(paymentPercent),
                currentPaymentBalance  = numberFormat(paymentBalance),
                currentPaymentTotal    = numberFormat(paymentTotal);

            let appendRow = "<tr>" +
                "<td>" + i + "</td>" +
                "<td>" + currentPaymentPercent + "</td>" +
                "<td>" + currentPaymentBalance + "</td>" +
                "<td>" + currentPaymentTotal + "</td>" +
                "<td>" + currentPreviousBalance + "</td>" +
                "</tr>";
            calculatorTable.insertAdjacentHTML('beforeend', '' + appendRow + '');
        }
    } else {
        if (values.jthType === 2) {

            let previousBalance = values.jthAmount;
            let paymentBalance = values.jthAmount / values.jthTerms;

            for (let i = 1; i <= values.jthTerms; i++) {
                let paymentPercent = previousBalance * ((values.jthPercent / 100) / 12);
                let paymentTotal   = paymentPercent + paymentBalance;
                previousBalance    = previousBalance - paymentBalance;

                let currentPreviousBalance = numberFormat(previousBalance),
                    currentPaymentPercent  = numberFormat(paymentPercent),
                    currentPaymentBalance  = numberFormat(paymentBalance),
                    currentPaymentTotal    = numberFormat(paymentTotal);

                let appendRow = "<tr>" +
                    "<td>" + i + "</td>" +
                    "<td>" + currentPaymentPercent + "</td>" +
                    "<td>" + currentPaymentBalance + "</td>" +
                    "<td>" + currentPaymentTotal + "</td>" +
                    "<td>" + currentPreviousBalance + "</td>" +
                    "</tr>";
                calculatorTable.insertAdjacentHTML('beforeend', '' + appendRow + '');
            }
        }
    }
    document.getElementById('main-modal-content').style.display = 'block';
}

function numberFormat(_number) {
    return  new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0
    }).format(Math.round(_number))
}

function closeModal() {
    document.getElementById('table').innerHTML = '';
    document.getElementById('main-modal-content').style.display = 'none';
}

function setMailingAddress(This) {
    const mailingAddress = document.getElementById('mailing_address');
    const propertySecurity = document.getElementById('property_security');
    if (This.checked){
        propertySecurity.value=mailingAddress.value;
    }else{
        propertySecurity.value = '';
    }
}
