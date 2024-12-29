(function($) {
    var tried_header = $('#tried-header');
    if (tried_header.length > 0) {
        tried_header.find('#activity-panel-tab-inbox').on('click');
        tried_header.find('#activity-panel-tab-inbox').on('click', function(e) {
            e.preventDefault();
            tried_header.find('.tried-layout__activity-panel-wrapper').toggleClass('is-open');
            $(this).toggleClass('is-active');
        });
    }

    $(document).on('click', '.boxcontain .boxcontain-toggle', function(e) {
        e.preventDefault();
        var boxcontain = $(this).closest('.boxcontain');
        if (boxcontain.data('closed') == 'false') {
            boxcontain.find('.boxcontain-body').slideDown();
            boxcontain.data('closed', 'true');
            $(this).removeClass('toggled');
        } else {
            boxcontain.find('.boxcontain-body').slideUp();
            boxcontain.data('closed', 'false');
            $(this).addClass('toggled');
        }
    });

    $(document).on('click', '.boxcontain .boxcontain-inside .button-action,\
    .boxcontain .boxcontain-inside .area-action-block .button-cancel,\
    .boxcontain .boxcontain-inside .area-action-block .button-save', function(e) {
        e.preventDefault();
        if ($(this).hasClass('button-action')) {
            $(this).hide();
            $(this).closest('.boxcontain-inside').find('.area-action-block[role="'+$(this).data('block')+'"]').toggleClass('opened');
            var a = $(this).closest('.boxcontain-inside');
        } else {
            $(this).closest('.area-action-block').toggleClass('opened');
            $(this).closest('.boxcontain-inside').find('.button-action.'+$(this).closest('.area-action-block').attr('role')).show();
        }
    });
})(jQuery);