(function ($) {
    'use strict';

    var pageparPrint = $('.pageper-print'),
        modalPrintbuilder = $('#modalPrintbuilder');

    if ( pageparPrint.length > 0 ) {
        var documentPrint = pageparPrint.find('.document-print'),
            builderPrint = pageparPrint.find('.builder-print');


        function resizePaper(isLandscape = false) {
            documentPrint.animate({height: (documentPrint.width() * 0.706).toString()}, 500);
        }
        resizePaper();

        $(document).on('click', '.builder-print .builder-collapse', function() {
            builderPrint.find('.builder-collapse.active').removeClass('active');
            builderPrint.find('.builder-option').slideUp(300);
            $(this).addClass('active');
            builderPrint.find(`.builder-option[role=${$(this).attr('data-option') ?? false}]`).slideDown(500);
        });

        // $(document).on('click', '.builder-print .step-btn', function() {
        //     var step = $(this).attr('data-step') ?? 'type',
        //         isOpenModal = ($(this).attr('data-omodal') && $(this).attr('data-omodal').toLowerCase() === 'true') ?? false;
            
        //     switchStep(step, isOpenModal);
        // });

        function switchStep(step, isOpenModal = false) {
            console.log(step);
            console.log(isOpenModal);
            if (step) {
                if (isOpenModal) modalPrintbuilder.toggleClass('opened');
                switch (step) {
                    case 'size':
                        break;
                    case 'print':
                        printDocument();
                        break;
                    default:
                        break;
                }
            }
        }

        function printDocument() {
            documentPrint.print({
                // Use Global styles
                globalStyles: false,
                // Add link with attrbute media=print
                mediaPrint: false,
                //Custom stylesheet
                stylesheet: false,
                //Print in a hidden iframe
                iframe: true,
                // Don't print this
                noPrintSelector: ".avoid-this",
                // Add this on top
                append: "Free jQuery Plugins<br/>",
                // Add this at bottom
                prepend: "<br/>jQueryScript.net",
                // Manually add form values
                manuallyCopyFormValues: true,
                // resolves after print and restructure the code for better maintainability
                deferred: $.Deferred(),
                // timeout
                timeout: 250,
                // Custom title
                title: null,
                // Custom document type
                doctype: '<!doctype html>'
            });
        }
    }

    $(document).on('click', '.close-collape', function() { $(this).parent().toggleClass('opened'); });
})(jQuery);