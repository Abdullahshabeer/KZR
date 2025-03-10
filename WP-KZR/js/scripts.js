var $ = jQuery;
jQuery(document).ready(function($) {
    jQuery('.toggle-button').click(function(){
		if (jQuery(this).hasClass('active')) {
			jQuery(this).removeClass('active');
			jQuery('body').removeClass('menu-open');
			jQuery('.site-navigation-wrap .site-navigation').css({ 'height': 'unset' });
			jQuery('.site-navigation .main-menu-wrap').css({ 'height': 'unset' });
		}
		else{
			jQuery(this).addClass('active');
			jQuery('body').addClass('menu-open');
			SetHeight();
		}
		$('.site-navigation-wrap .site-navigation').slideToggle(function() {
			SetHeight();
		});
	});

	// sticky header 
	const header = $(".main-header");
    const sticky = header.offset().top;
    $(window).on("scroll", function() {
        if ($(window).scrollTop() > sticky) {
            header.addClass("sticky-top");
        } else {
            header.removeClass("sticky-top");
        }
    });
	
	$('.owl-carousel').on('initialized.owl.carousel', function() {
        $(".owl-prev").attr("aria-label", carouselLabels.prevLabel);
        $(".owl-next").attr("aria-label", carouselLabels.nextLabel);
    });
	
	$('.owl-carousel.shortcuts-carousel').owlCarousel({
	    loop:false,
	    margin:30,
	    nav:true,
	    dots:false,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M20.7071 5.12749C21.0976 5.50581 21.0976 6.11919 20.7071 6.49751L11.4142 15.5L20.7071 24.5025C21.0976 24.8808 21.0976 25.4942 20.7071 25.8725C20.3166 26.2508 19.6834 26.2508 19.2929 25.8725L9.29289 16.185C8.90237 15.8067 8.90237 15.1933 9.29289 14.815L19.2929 5.12749C19.6834 4.74917 20.3166 4.74917 20.7071 5.12749Z" fill="#253136"/>\
				</svg>','<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2929 5.12749C11.6834 4.74917 12.3166 4.74917 12.7071 5.12749L22.7071 14.815C23.0976 15.1933 23.0976 15.8067 22.7071 16.185L12.7071 25.8725C12.3166 26.2508 11.6834 26.2508 11.2929 25.8725C10.9024 25.4942 10.9024 24.8808 11.2929 24.5025L20.5858 15.5L11.2929 6.49751C10.9024 6.11919 10.9024 5.50581 11.2929 5.12749Z" fill="#253136"/>\
			</svg>'],
		onInitialized: function() {
            $('.owl-nav').each(function() {
                $(this).attr({
                    'data-aos': 'fade-left',
                    'data-aos-delay': '1000',
                    'data-aos-easing': 'ease-out-back'
                });
            });
            AOS.refresh();
        },
	    responsive:{
	        0:{
	            items:1,
				stagePadding: 0,
	        },
			768:{
	            items:3,
				stagePadding: 50,
	        },
	        1199:{
	            items:6,
				stagePadding: 60,
	        },
	        1299:{
	            items:8
	        }
	    }
	});

	$('.owl-carousel.articles-carousel').owlCarousel({
	    loop:false,
	    margin:32,
	    nav:true,
	    dots:false,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M20.7071 5.12749C21.0976 5.50581 21.0976 6.11919 20.7071 6.49751L11.4142 15.5L20.7071 24.5025C21.0976 24.8808 21.0976 25.4942 20.7071 25.8725C20.3166 26.2508 19.6834 26.2508 19.2929 25.8725L9.29289 16.185C8.90237 15.8067 8.90237 15.1933 9.29289 14.815L19.2929 5.12749C19.6834 4.74917 20.3166 4.74917 20.7071 5.12749Z" fill="#253136"/>\
				</svg>','<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2929 5.12749C11.6834 4.74917 12.3166 4.74917 12.7071 5.12749L22.7071 14.815C23.0976 15.1933 23.0976 15.8067 22.7071 16.185L12.7071 25.8725C12.3166 26.2508 11.6834 26.2508 11.2929 25.8725C10.9024 25.4942 10.9024 24.8808 11.2929 24.5025L20.5858 15.5L11.2929 6.49751C10.9024 6.11919 10.9024 5.50581 11.2929 5.12749Z" fill="#253136"/>\
			</svg>'],
		onInitialized: function() {
            $('.owl-nav').each(function() {
                $(this).attr({
                    'data-aos': 'fade-left',
                    'data-aos-delay': '1000',
                    'data-aos-easing': 'ease-out-back'
                });
            });
            AOS.refresh();
        },
	    responsive:{
	        0:{
	            items:1,
				stagePadding: 0,
	        },
	        768:{
	            items:2,
				stagePadding: 50,
	        },
	        1199:{
	            items:3
	        }
	    }
	});

	$('.owl-carousel.training-carousel').owlCarousel({
	    loop:false,
	    margin:32,
	    nav:true,
	    dots:false,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M20.7071 5.12749C21.0976 5.50581 21.0976 6.11919 20.7071 6.49751L11.4142 15.5L20.7071 24.5025C21.0976 24.8808 21.0976 25.4942 20.7071 25.8725C20.3166 26.2508 19.6834 26.2508 19.2929 25.8725L9.29289 16.185C8.90237 15.8067 8.90237 15.1933 9.29289 14.815L19.2929 5.12749C19.6834 4.74917 20.3166 4.74917 20.7071 5.12749Z" fill="#253136"/>\
				</svg>','<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2929 5.12749C11.6834 4.74917 12.3166 4.74917 12.7071 5.12749L22.7071 14.815C23.0976 15.1933 23.0976 15.8067 22.7071 16.185L12.7071 25.8725C12.3166 26.2508 11.6834 26.2508 11.2929 25.8725C10.9024 25.4942 10.9024 24.8808 11.2929 24.5025L20.5858 15.5L11.2929 6.49751C10.9024 6.11919 10.9024 5.50581 11.2929 5.12749Z" fill="#253136"/>\
			</svg>'],
		onInitialized: function() {
            $('.owl-nav').each(function() {
                $(this).attr({
                    'data-aos': 'fade-left',
                    'data-aos-delay': '1000',
                    'data-aos-easing': 'ease-out-back'
                });
            });
            AOS.refresh();
        },
	    responsive:{
	        0:{
	            items:1,
				stagePadding: 0,
	        },
	        768:{
	            items:2,
				stagePadding: 50,
	        },
	        1199:{
	            items:3
	        }
	    }
	});
	$('.owl-carousel.gallery-carousel').owlCarousel({
	    loop:false,
	    margin:24,
	    nav:true,
	    dots:true,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M20.7071 5.12749C21.0976 5.50581 21.0976 6.11919 20.7071 6.49751L11.4142 15.5L20.7071 24.5025C21.0976 24.8808 21.0976 25.4942 20.7071 25.8725C20.3166 26.2508 19.6834 26.2508 19.2929 25.8725L9.29289 16.185C8.90237 15.8067 8.90237 15.1933 9.29289 14.815L19.2929 5.12749C19.6834 4.74917 20.3166 4.74917 20.7071 5.12749Z" fill="#fff"/>\
				</svg>','<svg xmlns="http://www.w3.org/2000/svg" width="32" height="31" viewBox="0 0 32 31" fill="none">\
				<path fill-rule="evenodd" clip-rule="evenodd" d="M11.2929 5.12749C11.6834 4.74917 12.3166 4.74917 12.7071 5.12749L22.7071 14.815C23.0976 15.1933 23.0976 15.8067 22.7071 16.185L12.7071 25.8725C12.3166 26.2508 11.6834 26.2508 11.2929 25.8725C10.9024 25.4942 10.9024 24.8808 11.2929 24.5025L20.5858 15.5L11.2929 6.49751C10.9024 6.11919 10.9024 5.50581 11.2929 5.12749Z" fill="#fff"/>\
			</svg>'],
	    responsive:{
	        0:{
	            items:1,
	        },
	        768:{
	            items:2,
	        },
	        992:{
	            items:3
	        }
	    }
	});
	
	$('.main-menu-wrap .menu-item-has-children > a').append('<span class="nav-toggle-icon"></span>');
	$('.nav-toggle-icon').click(function(e) {
		e.preventDefault();
		var clickedMenuItem 	= $(this).closest('.menu-item-has-children');
		var subMenu 			= clickedMenuItem.children('.sub-menu');
		
		clickedMenuItem.siblings('.menu-item-has-children').find('.sub-menu').slideUp();
		if (subMenu.is(':visible')) {
			subMenu.slideUp();
		} else {
			clickedMenuItem.find('.sub-menu').slideUp();
			subMenu.slideDown();
		}
	});
	
	// 	localized string 
	// 	
// 	$('a[href^="tel:"]').attr('title', localizedStrings.clickToCall);
//     $('a[href^="mailto:"]').attr('title', localizedStrings.clickToEmail);
	
	document.querySelectorAll('a').forEach(function(link) {
		const linkHostname = link.hostname;
		const currentHostname = window.location.hostname;

		if (link.href.startsWith('tel:')) {
			link.setAttribute('title', localizedStrings.clickToCall);
		} else if (link.href.startsWith('mailto:')) {
			link.setAttribute('title', localizedStrings.clickToEmail);
		} else if (linkHostname !== currentHostname) {
			if (link.target === "_blank") {
				link.setAttribute('title', 'link zewnętrzny, link otworzy się w nowej karcie');
			} else {
				link.setAttribute('title', 'link zewnętrzny');
			}
		}
	});

  	// Forms validations
  	$('.needs-validation').submit(function(event) {
	    if (!this.checkValidity()) {
	      event.preventDefault();
	      event.stopPropagation();
	    }
	    $(this).addClass('was-validated');
  	});
	// Attach an input event handler to all textareas with the class "char-limit"
	$('.char-limit').on('input', function() {
		var textArea = $(this);
		var charCount = textArea.closest('.form-group').find('.charCount');
		var maxLength = parseInt(textArea.attr('maxlength'));
		var currentLength = textArea.val().length;
		var remaining = maxLength - currentLength;

		charCount.text(currentLength + '/' + maxLength);

		if (remaining < 0) {
			textArea.addClass('char-limit-reached');
		} else {
			textArea.removeClass('char-limit-reached');
		}

		if (currentLength > maxLength) {
			textArea.val(textArea.val().substr(0, maxLength));
			charCount.text(maxLength + '/' + maxLength);
		}
	});
	
	
	document.addEventListener('wpcf7invalid', function(event) {
        // Delay the search for invalid fields to allow the DOM to update
        setTimeout(function() {
            // Calculate the height of the header
            var headerHeight = $('.main-header').outerHeight() || 0;

            // Find the first error field using aria-invalid or wpcf7-not-valid class
            var $firstErrorField = $('.wpcf7-not-valid, [aria-invalid="true"]').first();
            
            if ($firstErrorField.length) {
                console.log('First invalid field found.');

                // Scroll smoothly to the first error field, adjusting for header height
                var scrollPosition = $firstErrorField.offset().top - headerHeight - 80; // Adjust as needed
                
                $('html, body').animate({
                    scrollTop: scrollPosition
                }, 400, function() {
                    // Double-check the scroll position in case any layout changes occurred
                    var newScrollPosition = $firstErrorField.offset().top - headerHeight - 80;
                    $(window).scrollTop(newScrollPosition);  // Adjust again if necessary
                    
                    // Delay focus to ensure scrolling is complete
                    setTimeout(function() {
                        // Ensure the field is fully visible, then focus on it
                        $firstErrorField.focus();

                        // Optional: If focusing isn't working due to element type, try using .select() or focus parent element
                        if (!$firstErrorField.is(":focus")) { 
                            $firstErrorField.closest('input, select, textarea').focus();
                        }
                    }, 600); // Delay by 200ms to ensure the focus is applied after scrolling
                });
            } else {
                console.log('No invalid fields found.');
            }
        }, 100); // Delay by 100ms to ensure the DOM updates
    });
	
	// custom toggle for checkbox expand 
	$(".extra-content").hide();
	$(".checkbox-toggle a").click(function(e) {
		e.preventDefault();
		const toggleButton 	= $(this);
		const toggleContent = toggleButton.closest('.form-group').find(".extra-content");
		toggleContent.slideToggle(function() {
			// Toggle the text of the link when the content is shown/hidden
			if (toggleContent.is(":visible")) {
				toggleButton.text("Zwiń");
				toggleButton.closest('.checkbox-toggle').addClass("active");
			} else {
				toggleButton.text("Rozwiń");
				toggleButton.closest('.checkbox-toggle').removeClass("active");
			}
		});
		toggleButton.closest('.form-group').find(".required").toggle();
		$(".extra-content .required").show();
	});


    $( ".ordered-list" ).each(function() {
	  	var   val=1;
	    if ( $(this).attr("start")){
	  		val =  $(this).attr("start");
	    }
	  	val=val-1;
	 	val= 'li '+ val;
		$(this ).css('counter-increment',val );
	});

	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
			console.log('Element is in view');
			const $progressBar = $(entry.target);
			$progressBar.css('--percentage', '0');
			void $progressBar[0].offsetWidth;
			$progressBar.css('--percentage', $progressBar.css('--value'));
			$progressBar.addClass('start-animation');
			observer.unobserve(entry.target);
			}
		});
	}, {
		root: null,
		rootMargin: '0px',
		threshold: 0.1
	});
  
	$('[role="progressbar"]').each(function() {
	  	observer.observe(this);
	});

	// show hide content
    const wordLimit = 60; 
    $('.stage-card-row').each(function() {
        const $content = $(this).find('.content');
        const fullText = $content.html().trim(); 
        const wordCount = fullText.split(/\s+/).length;
        if (wordCount > wordLimit) {
            const truncatedText = fullText.split(/\s+/).slice(0, wordLimit).join(' ') + '...';
            $content.html(truncatedText);

            $content.append('<div class="toggle-btn text-end"><a href="#" class="toggle-content" data-expanded="false">więcej</a></div>');
            
            $content.data('full-text', fullText);
        }
    });
    $(document).on('click', '.toggle-content', function(e) {
        e.preventDefault();
        const $content = $(this).parents('.content');
        const fullText = $content.data('full-text');
        const isExpanded = $(this).data('expanded'); 

        if (isExpanded) {
            const truncatedText = fullText.split(/\s+/).slice(0, wordLimit).join(' ') + '...';
            $content.html(truncatedText);
            $content.append('<div class="toggle-btn text-end"><a href="#" class="toggle-content" data-expanded="false">więcej</a></div>');
        } else {
            $content.html(fullText);
            $content.append('<div class="toggle-btn text-end"><a href="#" class="toggle-content show-less" data-expanded="true">pokaż mniej</a></div>');
        }
    });
	
	
	
	
});

function SetHeight() {
	var HeaderHeight = jQuery('.main-header').outerHeight();
	var SearchHeight = jQuery('.site-navigation .search-form-wrap').is(':visible') ? jQuery('.site-navigation .search-form-wrap').outerHeight() : 0;
	var LSwitcherHeight = jQuery('.site-navigation .language-btn').is(':visible') ? jQuery('.site-navigation .language-btn').outerHeight() : 0;
	var TotalHeight = SearchHeight + LSwitcherHeight;

	var ViewportHeight = window.innerHeight;

	jQuery('.site-navigation-wrap .site-navigation').css({ 'height': 'calc(' + ViewportHeight + 'px - ' + HeaderHeight + 'px)' });
	jQuery('.site-navigation .main-menu-wrap').css({ 'height': 'calc(100% - ' + TotalHeight + 'px)' });
}

jQuery(window).on('resize orientationchange', function() {
	if (jQuery('body').hasClass('menu-open')) {
		SetHeight();
	}
});

// tabs to dropdown js
$(document).ready(function(){
    function createDropdown() {
        var dropdown = $('<div>', { class: 'dropdown' });
        var dropdownButton = $('<button>', {
            class: 'btn btn-secondary dropdown-toggle',
            type: 'button',
            id: 'dropdownMenuButton',
            'aria-expanded': 'false'
        }).text($('.nav-link.active').text());

        var dropdownMenu = $('<ul>', { class: 'dropdown-menu', 'aria-labelledby': 'dropdownMenuButton' });
        $('.nav-link').each(function(){
            var dropdownItem = $('<a>', {
                class: 'dropdown-item',
                href: '#',
                'data-bs-target': $(this).attr('data-bs-target')
            }).text($(this).text());

            if($(this).hasClass('active')){
                dropdownItem.addClass('active');
            }
            dropdownMenu.append(dropdownItem);
        });

        dropdown.append(dropdownButton).append(dropdownMenu);
        $('.tab-nav-sec').prepend(dropdown); 
    }

    function updateDropdownText() {
        $('#dropdownMenuButton').text($('.dropdown-item.active').text());
    }

    createDropdown();
    $(document).on('click', '#dropdownMenuButton', function(){
        var dropdownMenu = $(this).next('.dropdown-menu');

        if (dropdownMenu.hasClass('show')) {
            dropdownMenu.slideUp(200).removeClass('show');
        } else {
            dropdownMenu.slideDown(200).addClass('show');
        }
    });

    $(document).on('click', '.dropdown-item', function(e){
        e.preventDefault();
        $('.dropdown-item').removeClass('active');
        $(this).addClass('active');
        updateDropdownText();
        var target = $(this).data('bs-target');
        $('.tab-pane').removeClass('active show fade');
        $(target).addClass('fade');
        setTimeout(function(){
            $(target).addClass('show active');
        }, 100); 
        $('.nav-link').removeClass('active');
        $('[data-bs-target="'+target+'"]').addClass('active');
        $(this).closest('.dropdown-menu').slideUp(200).removeClass('show');
    });

    $('.nav-link').on('click', function(){
        var activeText = $(this).text();
        $('.dropdown-item').removeClass('active');
        $('.dropdown-item').filter(function(){
            return $(this).text() === activeText;
        }).addClass('active');
        updateDropdownText();
    });

    $(window).resize(function() {
		var windowWidth = window.innerWidth;
        if (windowWidth < 1199) {
            if (!$('.dropdown').length) {
                createDropdown();
            }
            $('.tab-nav-sec .nav').hide(); 
        } else {
            $('.dropdown').remove();
            $('.tab-nav-sec .nav').show(); 
        }
    }).trigger('resize');
	
	$('.btnPause').on('click', function() {
        var video = $(this).closest('.video-wrap').find('video').get(0);
        if (video) {
            video.pause();
            $(this).hide();
            $(this).siblings('.btnPlay').show();
        }
    });

    // Play the video and show the pause button
    $('.btnPlay').on('click', function() {
        var video = $(this).closest('.video-wrap').find('video').get(0);
        if (video) {
            video.play();
            $(this).hide();
            $(this).siblings('.btnPause').show();
        }
    });
});
function createDataTable(){
	var descriptonTitle = $('#filter-form').data('description-title');
	var table = new DataTable('#data-table', {
		paging: false,  // Disable built-in pagination
		info: false,
		ordering: false,
		pageLength: 10,
		language: {
			paginate: {
				next: '&#8250;',
				previous: '&#8249;',
			},
			lengthMenu: 'Wyniki wyszukiwania _MENU_',
		},
		layout: {
			topStart: null,
			topEnd: null,
			bottomEnd: {
				paging: {
					firstLast: false
				}
			}
		},
		columnDefs: [
			{
				className: 'dtr-control',
				orderable: false,
				targets: 0,
			}
		],
		order: [1, 'asc'],
		responsive: {
			breakpoints: [
				{name: 'bigdesktop', width: Infinity},
				{name: 'middesktop', width: 1450},
				{name: 'medium', width: 1299},
				{name: 'mobilep', width: 767},
			],
			details: {
				renderer: function(api, rowIdx, columns) {
					var windowWidth = $(window).width();
					var desktopThreshold = 1450;
	
					if (windowWidth >= desktopThreshold) {
						var header = '<thead><tr class="description-title"><td colspan="4">'+descriptonTitle+'</td></tr><tr>';
						var body = '<tbody><tr>';
	
						$.each(columns, function(i, col) {
							if (col.hidden) {
								header += '<th data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+col.title+'</th>';
								body += '<td data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'" tabindex="0">'+col.data+'</td>';
							}
						});
						header += '</tr></thead>';
						body += '</tr></tbody>';
						return $('<table class="table-details"/>').append(header + body);
					} else {
						return DataTable.Responsive.renderer.listHidden()(api, rowIdx, columns);
					}
				}
			}
		}
	});
}
function updateUrlParameter(param, value) {
    var url = new URL(window.location.href);
    url.searchParams.set(param, value);
    window.history.replaceState({}, '', url);
}
function getFilterInputsValues() {
	var filterValues = [];
	
	$('input[name="filter-inputs"]:checked').each(function() {
		var value = $(this).val();
		
		if (value) {
			filterValues.push(value);
		}
	});

	return filterValues;
}
function resetfilterformvalues(){
	$('#filter-form').find('input, select').each(function() {
		if ($(this).is('input[type="text"], input[type="email"], input[type="number"], input[type="password"]')) {
			$(this).val('').trigger('change');
		} else if ($(this).is('input[type="checkbox"], input[type="radio"]')) {
			$(this).prop('checked', false);
		} else if ($(this).is('select')) {
			$(this).val(null).trigger('change'); 
		}
	});
	
	$('#filter-form').find('textarea').val('');
}
$(document).ready(function () {
    AOS.init({
        duration: 1000,
        once: false, // Animations will happen multiple times if you scroll back up
        offset: 100,
        easing: 'ease-out',
        mirror: true // Allows animations to trigger when scrolling back up
    });

    // Refresh AOS on window scroll to fix missing animations
    $(window).on('scroll', function() {
        AOS.refresh();
    });
});
$(document).ready(function() {
	
	$('[data-bs-toggle="tooltip"]').tooltip({
        html: true // This allows HTML inside the tooltip
    });
    
	createDataTable();
	$('#submit-button').attr('disabled', true);

	function checkFormValues() {
		var hasValue = false;
		$('#filter-form').find('input, select').each(function() {
			var fieldValue = $(this).val();

			if (fieldValue && fieldValue.trim() !== '') {
				hasValue = true;
				return false;
			}
		});

		$('#submit-button').attr('disabled', !hasValue);
	}

	$('#filter-form').on('change keyup', 'input, select', function() {
		checkFormValues();
	});

	$('#filter-form').on('submit', function(e) {
		e.preventDefault();
		// performSearch();
		performAjaxCallForSearch(1);
	});
	$('[name="filter-inputs"]').on('change' , function(){
		$('#sortingselectoption').val('');
		performAjaxCallForSearch(1);
	})
	$('#reset-button').on('click', function() {
		resetfilterformvalues()
		$('#submit-button').attr('disabled', true);
		performAjaxCallForSearch(1);
	});
	$('#sortby').on('change' , function(){
		performAjaxCallForSearch(1);
	});
	$('#posts_per_page').on('change' , function(){
		performAjaxCallForSearch(1);
	});
	function performAjaxCallForSearch(paged=1) {
		var posts_per_page 	= 		$('#posts_per_page').val();
		// var params 			= 		new URLSearchParams(window.location.search); 
		// var paged 			= 		params.get('pageno');
		var nazwa_firmy 	=		$('#nazwa-firmy').val();
		var nip 			=		$('#nip').val();
		var adres_firmy 	=		$('#adres-firmy').val();
		var nr_certyfikatu 	=		$('#nr-certyfikatu').val();
		var nr_uczestnika 	=		$('#nr-uczestnika').val();
		var sortby 			=		$('#sortby').val();
		var selectfilters 	=		getFilterInputsValues();
		var filtersingle 	=		$('#sortingselectoption').val();
		var selectedfiltersc = selectfilters.join('+');
		if(filtersingle !== '' && filtersingle !== ' ') {
			selectedfiltersc = filtersingle;
		}
		updateUrlParameter('pageno', paged);
		$('.table-content-container .the-page-loader').css('display' , 'flex');
		$('#submit-button span#button-loader').show();
		$('#submit-button').attr('disabled', true);
		updateUrlParameter('posts_per_page' , posts_per_page);
		updateUrlParameter('nazwa_firmy' , nazwa_firmy);
		updateUrlParameter('nip' , nip);
		updateUrlParameter('adres_firmy' , adres_firmy);
		updateUrlParameter('nr_certyfikatu' , nr_certyfikatu);
		updateUrlParameter('nr_uczestnika' , nr_uczestnika);
		updateUrlParameter('filters' , selectedfiltersc);
		updateUrlParameter('sortby' , sortby);
		var ajax_url 	= ajax_object.ajax_url;
		$.ajax({
			url: ajax_url,
			type: 'GET',
			data: {
				action: 'get_certificates_apply_filters',
				posts_per_page: posts_per_page,
				pageno: paged,
				filters: selectedfiltersc,
				nazwa_firmy: nazwa_firmy,
				nip: nip,
				adres_firmy: adres_firmy,
				nr_certyfikatu: nr_certyfikatu,
				nr_uczestnika: nr_uczestnika,
				sortby:sortby
			},
			success: function(response) {
				$('#filtesr-page-content').html(response.content);
				$('.total-price-count .number-of-posts').text(response.total_posts)
				createDataTable();
				$('.table-content-container .the-page-loader').hide();
				$('#submit-button span#button-loader').hide();
				$('#submit-button').attr('disabled', false);
			},
			error: function(error) {
				$('.table-content-container .the-page-loader').hide();
				$('#submit-button span#button-loader').hide();
				$('#submit-button').attr('disabled', false);
			}
		});
	}
	$('#posts_per_page').on('change', function() {
		performAjaxCallForSearch(1);
	});
	
	$(document).on('click', '.pagination-container a', function(e) {
		e.preventDefault();
		var url 		= 		$(this).attr('href');
		var params 		= 		new URLSearchParams(url.split('?')[1]);
		var paged 		= 		params.get('paged');
		if(paged == null){
			paged = 1;
		}
		performAjaxCallForSearch(paged);
	});
	// function performSearch() {
	// 	var searchFields = {
	// 		2: $('#nr-certyfikatu').val(),
	// 		3: $('#nr-uczestnika').val(),
	// 		4: $('#nazwa-firmy').val(),
	// 		5: $('#adres-firmy').val(),
	// 		6: $('#nip').val(),
	// 		9: $('#country').val()
	// 	};

	// 	$.each(searchFields, function(columnIndex, fieldValue) {
	// 		if (fieldValue) {
	// 			table.column(columnIndex).search(fieldValue.trim(), true, false);
	// 		}
	// 	});

	// 	var selectedStatuses = [];
	// 	$('#filter-form .checkbox-inline input:checked').each(function() {
	// 		selectedStatuses.push($(this).val());
	// 	});

	// 	if (selectedStatuses.length > 0) {
	// 		var statusPattern = selectedStatuses.join('|');
	// 		table.column(1).search(statusPattern, true, false);
	// 	}
	// 	table.draw();
	// }

	// $('#filter-form').on('change keyup', 'input, select', function() {
	// 	var inputValue = $(this).val();
		
	// 	if (inputValue === '') { 
	// 		table.columns().search('').draw();
	// 	}
	// });

	$('.checkbox-inline input').on('change', function() {
		// if (!$(this).is(':checked')) {
		// 	var selectedStatuses = [];
		// 	$('#filter-form .checkbox-inline input:checked').each(function() {
		// 		selectedStatuses.push($(this).val());
		// 	});

		// 	if (selectedStatuses.length === 0) {
		// 		table.column(1).search('').draw();
		// 	}
		// }
	});
});
jQuery(document).ready(function($) {
    // Change the value of the first option
    $('#email-recipient option:first').val('default-value').text('wybierz odbiorcę');
});