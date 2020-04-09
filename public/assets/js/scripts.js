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
let amount = 100000,
    rate = ((6 / 100) / 12),
    term = 180;
result = amount * ((rate * (Math.pow(1 + rate, term))) / ((Math.pow(1 + rate, term)) - 1));

// console.log(result)

function openCalculatorModal() {
    const amount = document.getElementById('amount');
    const amortizationPeriod = document.getElementById('amortization_period');
    const term = document.getElementById('term');
    const interestOnly = document.getElementById('interestOnly');
    const percent = document.getElementById('rate');
    const startDate = document.getElementById('iad');
    const calculatorTable = document.getElementById('table');
    calculatorTable.innerHTML = '';

    let params = {
        amount: Number(amount.value.replace(/ /g, '')),
        term: term.value * 1,
        percent: parseFloat(percent.value),
        amortizePeriod: Number(amortizationPeriod.value),
        startDate: startDate.value,
        interestOnly: interestOnly.checked
    };

    if (params.interestOnly) {

        interestOnlyLoanPayment(params,calculatorTable)

    } else {

        amortizedLoanPayment(params,calculatorTable)
    }
    document.getElementById('main-modal-content').style.display = 'block';
}

function interestOnlyLoanPayment(params,calculatorTable) {

    for (let i = 1; i <= params.term; i++) {
        let paymentPercent = ((params.amount * (params.percent / 100)) / 12);
        let currentPaymentPercent = numberFormat(paymentPercent);
        let appendRow = "<tr>" +
            "<td>" + i + "</td>" +
            "<td>" + formatter(params.startDate, i) + "</td>" +
            "<td>" + currentPaymentPercent + "</td>" +
            "<td>" + 0 + "</td>" +
            "<td>" + 0 + "</td>" +
            "<td>" + params.amount + "</td>" +
            "</tr>";
        calculatorTable.insertAdjacentHTML('beforeend', '' + appendRow + '');
    }

}

function amortizedLoanPayment(params,calculatorTable) {
    let previousBalance = params.amount;
    let paymentTotal = (params.amount * (params.percent / 100) / 12) / (1 - (1 / (Math.pow((1 + (params.percent / 100) / 12), params.amortizePeriod))));

    for (let i = 1; i <= params.amortizePeriod; i++) {

        if (params.term){
            if (i-1 === params.term){
                return true;
            }
        }

        let paymentPercent = ((previousBalance * (params.percent / 100)) / 12),
            paymentBalance = (paymentTotal - paymentPercent),
            currentPreviousBalance = null,
            currentPaymentPercent = null,
            currentPaymentBalance = null,
            currentPaymentTotal = null;

        previousBalance = (previousBalance - paymentBalance);
        if (previousBalance < 0) {
            previousBalance = 0;
        }

        currentPreviousBalance = numberFormat(previousBalance);
        currentPaymentPercent = numberFormat(paymentPercent);
        currentPaymentBalance = numberFormat(paymentBalance);
        currentPaymentTotal = numberFormat(paymentTotal);

        let appendRow = "<tr>" +
            "<td>" + i + "</td>" +
            "<td>" + formatter(params.startDate, i) + "</td>" +
            "<td>" + currentPaymentPercent + "</td>" +
            "<td>" + currentPaymentBalance + "</td>" +
            "<td>" + currentPaymentTotal + "</td>" +
            "<td>" + currentPreviousBalance + "</td>" +
            "</tr>";
        calculatorTable.insertAdjacentHTML('beforeend', '' + appendRow + '');
    }
}

function formatter(starDate, month) {
    const starDateMonth = new Date(starDate).getUTCMonth() + Number(month);
    let date = new Date(new Date(starDate).setMonth(starDateMonth,0));
    let options = {year: 'numeric', month: 'short', day: 'numeric'};

    const formatter = new Intl.DateTimeFormat('en', options);
    return formatter.format(date);
}

function monthlyPayment(params, $cond = true) {
    let totalDifferent = differentDate(params.start_date);

    if (params.payment_type===1) {

        let percent = ((params.amount * (params.rate / 100)) / 12);

        for (let i = 1; i <= params.term; i++) {

            if (totalDifferent === i || totalDifferent <1) {
                return $cond ? numberFormat(percent) : numberFormat(params.amount);
            }

        }

    } else {
        let term = params.amortization_period;

        let previousBalance = params.amount;
        let paymentTotal = (params.amount * (params.rate / 100) / 12) / (1 - (1 / (Math.pow((1 + (params.rate / 100) / 12), term))));

        for (let i = 1; i <= params.amortization_period; i++) {

            let paymentPercent = ((previousBalance * (params.rate / 100)) / 12);
            let paymentBalance = (paymentTotal - paymentPercent);
            previousBalance = (previousBalance - paymentBalance);

            if (previousBalance < 0) {
                previousBalance = 0;
            }

            if (totalDifferent === i || totalDifferent < 1) {
                return $cond ? numberFormat(paymentTotal) : numberFormat(previousBalance);
            }
        }
    }
}

function differentDate($date) {
    let date1 = new Date($date),
        date2 = new Date(),
        startYear = date1.getFullYear(),
        startMonth = date1.getUTCMonth(),
        currentYear = date2.getFullYear(),
        currentMonth = date2.getUTCMonth();

    if ((currentYear <= startYear) && (startMonth > currentMonth)) {
        return -1
    }

    let dateDiff = Math.abs(currentYear - startYear) * 12;
    let monthDiff = (Math.abs(currentMonth - startMonth));
    return dateDiff + monthDiff;
}

function formatNumber(num) {
    let number = num.replace(/ /g, '');
    return number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

function numberFormat(_number) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(_number)
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
