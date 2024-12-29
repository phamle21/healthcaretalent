(function ($) {
    "use strict";
    /**
     * https://tried.vn/
     */

    if ($(document).scrollTop() > 40) {
        $('body').addClass('scrolling');
    }
    $(window).scroll(function() {
        if ($(document).scrollTop() > 40) {
            $('body').addClass('scrolling');
        } else {
            $('body').removeClass('scrolling');
        }
    });

    $(document).on('click', '.toggle-searchjob a, .site-searchjob .cancel_submit a', function() {
        var parent = $(this).parent(),
            site_searchjob = $('.site-searchjob'),
            site_main = $('.site-main');
            
        if (parent.hasClass('toggle-searchjob')) {
            site_searchjob.show();
            site_main.addClass('toggled');
        } else {
            site_searchjob.hide();
            site_main.removeClass('toggled');
        }
    });

    /** Contact form 7 */
    $(document).on('click', '.wpcf7-form input[type="submit"]', function() {
        var form = $(this).closest('.wpcf7-form');

        form.find('.wpcf7-form-control-wrap').each(function() { $(this).removeClass('valid'); });
        setTimeout(function() {
            form.find('.wpcf7-form-control-wrap').each(function() { $(this).addClass('valid'); });
        }, 300);
    });

    
    $('.section-event-carouselupcoming').find('.info-block a').on('click', function(e) {
		e.preventDefault();
		$([document.documentElement, document.body]).animate({
			scrollTop: $($(this).attr('href')).offset().top - 100
		}, 500);
	});

    const popupHomepage = $('#popup-homepage');
    if (popupHomepage) {
        // var keyCookiePopupHomepage = 'popup-homepage',
        //     getCookiePopupHomepage = readCookie(keyCookiePopupHomepage) ?? false;
        // if ( !getCookiePopupHomepage ) {
        //     popupHomepage.show();
        // }
        // popupHomepage.find('.popup-wrapper, .popup-wrapper ,popup-main_close').on('click', function() {
        //     $(this).parent().remove();
        //     createCookie(keyCookiePopupHomepage, true, 7);
        // });

        popupHomepage.show();
        popupHomepage.find('.popup-wrapper, .popup-wrapper ,popup-main_close').on('click', function() {
            $(this).parent().remove();
        });
    }
    
	function createCookie(name, value, days) {
        var expires = '';
    
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toGMTString();
        }
        document.cookie = encodeURIComponent(name) + '=' + encodeURIComponent(value) + expires + '; path=/';
    }
    function readCookie(name) {
        var nameEQ = encodeURIComponent(name) + '=',
            ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
        return null;
    }
    function eraseCookie(name) {
        createCookie(name, '', -1);
    }

    $(document).on('click', '.section-contact-infocollapse .infocollapse-item > a', function() {
        var wrapper = $(this).closest('.section-contact-infocollapse'),
            parent = $(this).parent();

        if (parent.hasClass('active')) {
            parent.removeClass('active');
        } else {
            wrapper.find('.infocollapse-item.active').removeClass('active');
            parent.addClass('active');
        }
    });

    $(document).on('mouseover', '#mega-menu-header-menu .mega-context > ul.mega-sub-menu > li > a', function() {
        var parent = $(this).parent();
        parent.addClass('active').siblings().removeClass('active');
    });

    $(document).on('click', '.section-another-explore_advicecats .advice_cats-root > a', function() {
        var wrapper = $(this).closest('.advice_cats-block'),
            catid = $(this).attr('data-catid');

        wrapper.find(`.advice_cats-root > a[data-catid="${catid}"]`).addClass('active').siblings().removeClass('active');
        wrapper.find(`.group-advice-catchild[data-role="${catid}"]`).addClass('active').siblings().removeClass('active');
    });

    $(document).on('click', `.open-modal,
			.modal-tried .modal-overlay,
			.modal-tried .box-icon--close,
			.modal-tried .btn-cancel`, function() {
			var modal = $(this).closest('.modal-tried');
			
			if ($(this).hasClass('open-modal')) {
				modal = $($(this).attr('data-target'));
				
				let role = $(this).attr('role');
						
				if ( $(this).attr('data-target') == '#modal-regwheel' ) {
					if (role && role == 'event') {
						modal.find('.modal-body.event').show();
						modal.find('.modal-body:not(.event)').hide();

					} else {
						modal.find('.modal-body.event').hide();
						modal.find('.modal-body:not(.event)').show();
					}
				}
			}
			modal.toggleClass('opened');
	});

    const formJobFiltersNotHead = $('.job_filters:not(.head)');
    if (formJobFiltersNotHead.length == 0) {
        var formJobFiltersNotHead_findjob = $('.section-header-action .findjob-block');

        formJobFiltersNotHead_findjob.addClass('toggle-searchjob');
        formJobFiltersNotHead_findjob.find('a').attr( 'href', 'javascript:void(0)' );
    }

    $(document).on('click', '.job_filters .actionbtns_filters a', function() {
        var form = $(this).closest('.job_filters'),
            togglefilter_jobs = form.find('.togglefilter_jobs'),
            actionbtns_filters = form.find('.actionbtns_filters'),
            roleid = $(this).attr('data-roleid');

        if (togglefilter_jobs.find(`.togglefilter_jobs-item[data-toggleid="${roleid}"]`).hasClass('active')) {
            togglefilter_jobs.find(`.togglefilter_jobs-item[data-toggleid="${roleid}"]`).removeClass('active');
            actionbtns_filters.find(`a[data-roleid="${roleid}"]`).removeClass('active');
        } else {
            actionbtns_filters.find('a').removeClass('active');
            actionbtns_filters.find(`a[data-roleid="${roleid}"]`).addClass('active');
            togglefilter_jobs.find('.togglefilter_jobs-item').removeClass('active');
            togglefilter_jobs.find(`.togglefilter_jobs-item[data-toggleid="${roleid}"]`).addClass('active');

            $(document).on('click', function(e) {
                setTimeout(function() {
                    if (!$(e.target).closest('.togglefilter_jobs-item').length > 0 && !$(e.target).closest('.actionbtns_filters').length > 0) {
                        $('.togglefilter_jobs-item.active').removeClass('active');
                    }
                }, 300);
            });
        }
    });

    $(document).on('click', '#scroll-top', function(e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 600);
    });

    $(document).on('click', '.search-action-block .searchform-action', function(e) {
        var wrapper = $(this).closest('.search-action-block');
        if (wrapper.hasClass('opened')) {
            wrapper.removeClass('opened');
        } else {
            wrapper.addClass('opened');
        }
    });

    $(document).on('click', '.site-navigation-toggle, .site-cart-toggle', function(e) {
        var wrapper = $(this).closest('.site-navigation');
        var role = ($(this).attr('role') && $(this).attr('role') != '')?$(this).attr('role'):"menu";
        if (wrapper.hasClass('opened')) {
            wrapper.removeClass('opened');
            wrapper.attr('role', '');
        } else {
            wrapper.addClass('opened');
            wrapper.attr('role', role);
        }
    });
    $(document).on('click', '.site-navigation.opened', function(e) {
        $(this).find('.site-navigation-wrapper').click(function() {
            $('.site-navigation.opened').addClass('progress');
        });
        if (!$('.site-navigation.opened').hasClass('progress')) {
            $('.site-navigation.opened').removeClass('opened');
        }
        $('.site-navigation.opened').removeClass('progress');
    });

    $(document).on('click', '.cart-toggle', function(e) {
        var wrapper = $(this).parent();
        if (wrapper.find('.cart-wrapper').hasClass('opened')) {
            wrapper.find('.cart-wrapper').removeClass('opened');
        } else {
            wrapper.find('.cart-wrapper').addClass('opened');
        }
    });

    if ($('.section-home-slider').length > 0) {
        $('.section-home-slider').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_slider = new Swiper(".widget-home-slider", {
                grabCursor: true,
                loop: true,
                autoplay: false,
                speed: 750,
                // effect: "creative",
                // creativeEffect: {
                //     prev: {
                //         shadow: true,
                //         translate: ["-20%", 0, -1],
                //     },
                //     next: {
                //         translate: ["100%", -1, 0],
                //     },
                // },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                // pagination: {
                //     el: ".swiper-pagination",
                //     clickable: true
                // }
            });
        });
    }

    if ($('.section-home-latest_job').length > 0) {
        $('.section-home-latest_job').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_latest_job = new Swiper(".widget-home-latest_job", {
                slidesPerView: 3,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                slidesPerView: "auto",
                loop: false,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }

    if ($('.section-event-latestevent').length > 0) {
        $('.section-event-latestevent').each(function() {
            let control = $(this).attr('data-control');
            const widget_event_latestevent = new Swiper(".widget-event-latestevent", {
                slidesPerView: 3,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }

    if ($('.section-home-latest_advice').length > 0) {
        $('.section-home-latest_advice').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_latest_advice = new Swiper(".widget-home-latest_advice", {
                slidesPerView: 3,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }
    
    if ($('.section-home-partner').length > 0) {
        $('.section-home-partner').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_partner = new Swiper(".widget-home-partner", {
                slidesPerView: 5,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 5,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    if ($('.section-home-recapgallery').length > 0) {
        $('.section-home-recapgallery').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_recapgallery = new Swiper(".widget-home-recapgallery", {
                slidesPerView: 3,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    }
                }
            });
        });
    }

    if ($('.section-another-listclient').length > 0) {
        $('.section-another-listclient').each(function() {
            let control = $(this).attr('data-control');
            const widget_another_listclient = new Swiper('.section-another-listclient[data-control="'+control+'"] .widget-another-listclient', {
                slidesPerView: 6,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 1000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 6,
                        spaceBetween: 10
                    }
                }
            });
        });
    }

    if ($('.section-home-client').length > 0) {
        $('.section-home-client').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_client = new Swiper('.section-home-client[data-control="'+control+'"] .widget-home-client', {
                slidesPerView: 5,
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 5,
                        spaceBetween: 10
                    }
                }
            });
        });
    }

    if ($('.section-another-cardbox').length > 0) {
        $('.section-another-cardbox').each(function() {
            let control = $(this).attr('data-control');
            const widget_another_cardbox = new Swiper(".widget-another-cardbox", {
                slidesPerView: 3    ,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    520: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                }
            });
        });
    }
    
    if ($('.section-home-testimonial').length > 0) {
        $('.section-home-testimonial').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_testimonial = new Swiper(".widget-home-testimonial", {
                slidesPerView: 3,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                }
            });
        });
    }
    
    if ($('.widget-single-relate').length > 0) {
        $('.widget-single-relate').each(function() {
            let control = $(this).attr('data-control');
            const widget_single_relate = new Swiper(".widget-single-relate", {
                slidesPerView: 3,
                spaceBetween: 20,
                // navigation: {
                //     nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                //     prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                // },
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    if ($('.section-home-catproduct').length > 0) {
        $('.section-home-catproduct').find('.category-block').each(function() {
            let control = $(this).attr('data-control');
            let swiper_catproduct = new Swiper('.widget-home-catproduct-'+control, {
                slidesPerView: 4,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    960: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    if ($('.section-home-product').length > 0) {
        $('.section-home-product').each(function() {
            let control = $(this).attr('data-control');
            const swiper_products = new Swiper('.widget-home-product', {
                slidesPerView: 4,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    960: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    if ($('.section-home-blog').length > 0) {
        $('.section-home-blog').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_blog = new Swiper(".widget-home-blog", {
                slidesPerView: 3,
                spaceBetween: 10,
                loop: false,
                autoplay: {
                    delay: 5000,
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    560: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    }
                }
            });
        });
    }
    
    if ($('.section-swiper').length > 0) {
        $('.section-swiper').each(function() {
            let control = $(this).attr('data-control'),
                setLoop = false,
                setSlidesPerView = 1,
                setSpaceBetween = 10,
                setNav = {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                setAutoplay = {
                    delay: 5000,
                },
                setPagination = {
                    el: '.swiper-pagination[key="'+control+'"]',
                    clickable: true
                },
                setEffect = false;
            if ($(this).attr('data-loop') == 'true' || $(this).attr('data-loop') == 1) {
                setLoop = true;
            }
            if ($(this).attr('data-nav') == 'false' || $(this).attr('data-nav') == 0) {
                setNav = false;
            }
            if ($(this).attr('data-pagination') == 'false' || $(this).attr('data-pagination') == 0) {
                setPagination = false;
            }
            if ($(this).attr('data-effect')) {
                setEffect = $(this).attr('data-effect');
            }
            new Swiper('.section-swiper[data-control="'+control+'"] .swiper', {
                slidesPerView: setSlidesPerView,
                spaceBetween: setSpaceBetween,
                loop: setLoop,
                autoplay: setAutoplay,
                navigation: setNav,
                pagination: setPagination,
                effect: setEffect,
                fadeEffect: {
                    crossFade: true
                }
            });
        });
    }

    if ($('.section-home-review').length > 0) {
        $('.section-home-review').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_review = new Swiper(".widget-home-review", {
                slidesPerView: 2,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                // navigation: {
                //     nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                //     prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                // },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    767: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }

    if ($('.section-another-highlightevent').length > 0) {
        $('.section-another-highlightevent').each(function() {
            let control = $(this).attr('data-control');
            const widget_home_review = new Swiper(".widget-another-highlightevent", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: false,
                autoplay: {
                    delay: 5000,
                },
                direction: "vertical"
            });
        });
    }

    if ($('.section-another-review').length > 0) {
        $('.section-another-review').each(function() {
            let control = $(this).attr('data-control');
            const widget_another_review = new Swiper(".widget-another-review", {
                slidesPerView: 2,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    767: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }

    if ($('.section-another-slide_advice').length > 0) {
        $('.section-another-slide_advice').each(function() {
            let control = $(this).attr('data-control');
            const swiper_another_slide_advice = new Swiper('.widget-another-slide_advice', {
                slidesPerView: 3,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    960: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    }
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }


    if ($('.section-contact-infoform').length > 0) {
        $('.section-contact-infoform').each(function() {
            let control = $(this).attr('data-control');
            const swiper_contact_infoform = new Swiper('.widget-contact-infoform', {
                slidesPerView: 1,
                spaceBetween: 10,
                loop: true,
                autoplay: {
                    delay: 5000,
                },
                navigation: {
                    nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                    prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                }
            });
        });
    }

    // var widget_home_review_thumb = new Swiper(".widget-home-review-thumb", {
    //     centeredSlides: true,
    //     centeredSlidesBounds: true,
    //     slidesPerView: 3,
    //     watchOverflow: true,
    //     watchSlidesVisibility: true,
    //     watchSlidesProgress: true,
    //     direction: 'vertical',
    //     autoplay: {
    //         delay: 5000,
    //     },
    // });

    // var widget_home_review = new Swiper(".widget-home-review", {
    //     watchOverflow: true,
    //     watchSlidesVisibility: true,
    //     watchSlidesProgress: true,
    //     preventInteractionOnTransition: true,
    //     effect: "fade",
    //     fadeEffect: {
    //         crossFade: true
    //     },
    //     autoplay: {
    //         delay: 5000,
    //     },
    //     navigation: {
    //         nextEl: '.swiper-button.swiper-button-next',
    //         prevEl: '.swiper-button.swiper-button-prev',
    //     },
    //     thumbs: {
    //         swiper: widget_home_review_thumb
    //     }
    // });
    // widget_home_review_thumb.on('slideChangeTransitionStart', function() {
    //     widget_home_review_thumb.slideTo(widget_home_review.activeIndex);
    // });
    
    // widget_home_review_thumb.on('transitionStart', function(){
    //     widget_home_review.slideTo(widget_home_review_thumb.activeIndex);
    // });
    
    if ($('.section-home-member').length > 0) {
        $('.section-home-member').each(function() {
            let control = $(this).attr('data-control');
            const swiper_home_member = new Swiper('.widget-home-member', {
                slidesPerView: 4,
                spaceBetween: 20,
                loop: false,
                autoplay: {
                    delay: 5000,
                },
                // navigation: {
                //     nextEl: '.swiper-button.swiper-button-next[key="'+control+'"]',
                //     prevEl: '.swiper-button.swiper-button-prev[key="'+control+'"]',
                // },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    960: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    }
                }
            });
        });
    }

    if ($('.section-event-carouselupcoming').length > 0) {
        $('.section-event-carouselupcoming').each(function() {
            let control = $(this).attr('data-control');
            const swiper_event_carouselupcoming = new Swiper('.widget-event-carouselupcoming', {
                slidesPerView: 2,
                spaceBetween: 10,
                loop: true,
                grabCursor: true,
                centeredSlides: true,
                slideActiveClass: "active",
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                },
                autoplay: {
                    enabled: true,
                    delay: 5000
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    1024: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    }
                }
            });
        });
    }


    const sectionAnotherContent = $('.section-another-content');
    if (sectionAnotherContent.length > 0) {
        sectionAnotherContent.find('.content-block').each(function() {
            if ($(this).hasClass('full')) return;
            var _height = 300;

            if ($(this).find('.contents').height() > _height) {
                $(this).find('.contents').css('max-height', _height);
                $(this).addClass('load-showmore');
            } else {
                $(this).find('.content-collapse').remove();
            }
        });

        sectionAnotherContent.find('.content-block > .content-collapse').on('click', function() {
            var wrapper = $(this).closest('.content-block'),
                collapse = wrapper.find('.content-collapse'),
                _heightTransform = '300px';
            
            if (wrapper.hasClass('showmore')) {
                wrapper.find('.contents').css('max-height', _heightTransform);
                collapse.text(collapse.attr('data-more'));
                wrapper.removeClass('showmore');
            } else {
                wrapper.find('.contents').css('max-height', '100%');
                collapse.text(collapse.attr('data-less'));
                wrapper.addClass('showmore');
            }
        });
    }


    const calevents_detail_page = $('.main-contain.calevents-detail');
    if (calevents_detail_page.length > 0) {
        calevents_detail_page.find('.content-block').each(function() {
            var _height = 300;

            if ($(this).find('.contents').height() > _height) {
                $(this).find('.contents').css('max-height', _height);
                $(this).addClass('load-showmore');
            } else {
                $(this).find('.content-collapse').remove();
            }
        });

        calevents_detail_page.find('.content-block > .content-collapse').on('click', function() {
            var wrapper = $(this).closest('.content-block'),
                collapse = wrapper.find('.content-collapse'),
                _heightTransform = '300px';
            
            if (wrapper.hasClass('showmore')) {
                wrapper.find('.contents').css('max-height', _heightTransform);
                collapse.text(collapse.attr('data-more'));
                wrapper.removeClass('showmore');
            } else {
                wrapper.find('.contents').css('max-height', '100%');
                collapse.text(collapse.attr('data-less'));
                wrapper.addClass('showmore');
            }
        });
    }


    $( document ).on( 'change', 'select.slct-provinces', function(e) {
		e.preventDefault();
        var wrapper = $(this).closest('.slct-position'),
            province_service = $('option:selected', this).attr('data-service'),
            province_id = $(this).val();
        if ( province_id ) {
            $.ajax({
                type : "get", 
                url : tried_script.ajax_url, 
                data : {
                    action: 'render_districts',
                    province: province_service
                },
                beforeSend: function() {
                    wrapper.find('.slct-provinces').attr('disabled', 'disabled');
                    wrapper.find('.slct-districts').attr('disabled', 'disabled');
                },
                success: function(res) {
                    if ( res.code == 200 ) {
                        wrapper.find('.slct-districts').html('<option value="">Chọn huyện</option>');
                        res.response.forEach(function(item) {
                            wrapper.find('.slct-districts').append(`<option value="${item.district_service_order}-${item.district_service_key}" data-type="${item.type}" data-service="${item.district_service_key}">${item.name}</option>`);
                        });
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                complete: function() {
                    wrapper.find('.slct-provinces').removeAttr('disabled');
                    wrapper.find('.slct-districts').removeAttr('disabled');
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
	} );
    


    // initializeSelect2($('.select2-location'));

    // function initializeSelect2(slct, dynamic = false) {
    //     var selectValue = [],
    //         args = {
    //             width: 'style',
    //             allowClear: true,
    //             placeholder: "Region, city..."
    //         };
    //     if (dynamic) {
    //         args.tags = true;
    //     }
    //     slct.select2(args);
    //     slct.find('option').each(function() {
    //         if ($(this).val() != '') selectValue.push($(this).val());
    //     });
    //     slct.val(selectValue).val('').trigger('change');
    // }

    // quick search regex
    // var buttonFilter;
    // // init Isotope
    // var $grid = $('#tabs-contain .gallery').isotope({
    //     itemSelector: '.item',
    //     layoutMode: 'fitRows',
    //     filter: function() {
    //         var $this = $(this);
    //         var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
    //         return buttonResult;
    //     }
    // });

    // $('ul#tabs-filtering').on( 'click', 'li a', function() {
    //     buttonFilter = $( this ).attr('data-filter');
    //     $('ul#tabs-filtering li a.active').removeClass('active');
    //     $(this).addClass('active');
    //     $grid.isotope();
    // });

    // jQuery( document.body ).on( 'updated_cart_totals removed_from_cart', function( event, fragments, cart_hash, $button ) {
    //      $('.cart-block .cart-wrapper').html(fragments['div.widget_shopping_cart_content']);
    // });

    function randID(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
        }
        return result;
    }
})(jQuery);
