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


// Example Monthly Payment
let amount = 20000,
    rate = (0.00625),
    term = 60;
result = amount * ((rate * (Math.pow(1 + rate, term))) / ((Math.pow(1 + rate, term)) - 1));

function openCalculatorModal() {
    const amortize = 1,
          amount = document.getElementById('amount'),
          amortizationPeriod = document.getElementById('amortization_period'),
          interestPeriod = document.getElementById('term'),
          interestOnly = document.getElementById('interestOnly'),
          currentRate = document.getElementById('rate')
          calculatorTable = document.getElementById('table');
    let values = {};

    calculatorTable.innerHTML = '';

    values.jthAmount = parseInt(Number(amount.value.replace(/ /g, '')));
    values.jthPercent = parseFloat(currentRate.value);
    values.jthTerms = parseInt(amortizationPeriod.value);
    values.jthType = amortize;
    values.interestPeriond = parseInt(interestPeriod.value);

    if (values.jthType === 1) {
        let term =  values.jthTerms;

        if (interestOnly.checked && values.interestPeriond){
            term = values.jthTerms - values.interestPeriond
        }

        let previousBalance = values.jthAmount,
            paymentTotal = (values.jthAmount * (values.jthPercent / 100) / 12) / (1 - (1 / (Math.pow((1 + (values.jthPercent / 100) / 12), term))));

        for (let i = 1; i <= values.jthTerms; i++) {

            let paymentPercent = ((previousBalance * (values.jthPercent / 100)) / 12),
                paymentBalance = (paymentTotal - paymentPercent),
                currentPreviousBalance = null,
                currentPaymentPercent   = null,
                currentPaymentBalance   = null,
                currentPaymentTotal     = null;

            if (interestOnly.checked && i <= values.interestPeriond) {

                currentPreviousBalance = numberFormat(previousBalance);
                currentPaymentPercent = numberFormat(paymentPercent);
                currentPaymentBalance = 0;
                currentPaymentTotal = currentPaymentPercent;

            } else {

                previousBalance = (previousBalance - paymentBalance);
                if (previousBalance < 0) {
                    previousBalance = 0;
                }
                currentPreviousBalance = numberFormat(previousBalance);
                currentPaymentPercent = numberFormat(paymentPercent);
                currentPaymentBalance = numberFormat(paymentBalance);
                currentPaymentTotal = numberFormat(paymentTotal);

            }

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
    document.getElementById('main-modal-content').style.display = 'block';
}

function monthlyPayment(params, $cond = true) {

    let totalDifferent = differentDate(params.start_date);

    for (let [key, value] of Object.entries(params)) {
        if (value === null) {
            return ''
        }
    }
    let term = params.amortization_period;
    if (params.payment_type === 1 && params.term) {
        term  =  (params.amortization_period - params.term);
    }

    let previousBalance = params.amount;
    let paymentTotal = (params.amount * (params.rate / 100) / 12) / (1 - (1 / (Math.pow((1 + (params.rate / 100) / 12), term))));

    for (let i = 1; i <= params.amortization_period; i++) {

        if (params.payment_type === 1 && i <= params.term && $cond) {
            return numberFormat(paymentTotal);
        }

        let paymentPercent = ((previousBalance * (params.rate / 100)) / 12);
        let paymentBalance = (paymentTotal - paymentPercent);
            previousBalance = (previousBalance - paymentBalance);

        if (previousBalance < 0) {
            previousBalance = 0;
        }

        if (totalDifferent === i) {
            return $cond ? numberFormat(paymentTotal) : numberFormat(previousBalance);
        }
    }
}

function differentDate($date) {
    let startDate = new Date($date),
        currentDate = new Date(),
        startYear = Number(startDate.getFullYear()),
        currentYear = Number(currentDate.getFullYear()),
        startMonth = Number(startDate.getUTCMonth() + 1),
        currentMonth = Number(currentDate.getUTCMonth() + 1);

    let totalYear = (currentYear - startYear);
    let totalDifferent = (startMonth - currentMonth);

    if (totalYear > 0 && totalDifferent === 0) {

        totalDifferent += (totalYear * 12);

    } else if (totalYear > 0 && totalDifferent !== 0) {

        totalDifferent = ((12 - startMonth) + currentMonth);

    } else {

        if (totalYear === 0 && totalDifferent === 0) {
            totalDifferent++;
        }

    }

    return totalDifferent;
}

function formatNumber(num) {
    let number = num.replace(/ /g, '');
    return number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

function numberFormat(_number) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 0
    }).format(parseInt(Math.round(_number)))
}

function closeModal() {
    document.getElementById('table').innerHTML = '';
    document.getElementById('main-modal-content').style.display = 'none';
}

function setMailingAddress(This) {
    const mailingAddress = document.getElementById('mailing_address');
    const propertySecurity = document.getElementById('property_security_1');
    if (This.checked) {
        propertySecurity.value = mailingAddress.value;
    } else {
        propertySecurity.value = '';
    }
}
