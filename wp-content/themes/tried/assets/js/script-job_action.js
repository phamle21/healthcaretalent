(function ($) {
    'use strict';

    $(document).on('click', 'a.savejob', function() {
        var _this = $(this),
            jobID = _this.attr('data-job_id') ?? false;

        if ( jobID ) {
            $.ajax({
                type : "get", 
                url : tried_script.ajax_url, 
                data : {
                    action: 'tried_jobpost_update_savejobs',
                    job_id: jobID
                },
                beforeSend: function() {
                    // coding
                },
                success: function(res) {
                    if (res.code == 200 && res.result) {
                        console.log(res.result[jobID]);
                        if (res.result.includes(jobID)) {
                            _this.addClass('active');
                        } else {
                            _this.removeClass('active');
                        }
                        $('.section-header-action .savejob-block .count').text(res.result.length);
                    } else if (res.code == 301) {
                        window.location.href = res.result;
                    } else {
                        console.log('Có lỗi xảy ra!');
                    }
                },
                complete: function() {
                    // coding
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
    });
})(jQuery);