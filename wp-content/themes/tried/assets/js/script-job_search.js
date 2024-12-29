(function ($) {
    'use strict';

    const sectionAnotherJobsearch = $('.section-another_jobsearch');
    if (sectionAnotherJobsearch.length > 0) {
        sectionAnotherJobsearch.find('.jobsearch-item').each(function() {
            var _height = 204;
            if ($(this).attr('id') == 'jobsearch-sector') {
                _height = 210;
            }
            if ($(this).find('.contain').height() < _height) {
                $(this).addClass('none-showmore');
            }
        });

        sectionAnotherJobsearch.find('.jobsearch-actcollapse a').on('click', function() {
            var wrapper = $(this).closest('.jobsearch-item'),
                _heightTransform = '204px';
            
            if (wrapper.attr('id') == 'jobsearch-sector') {
                _heightTransform = '252px';
            }
            if ($(this).hasClass('less')) {
                wrapper.find('.contain').css('max-height', _heightTransform);
                $(this).removeClass('less');
            } else {
                wrapper.find('.contain').css('max-height', '100%');
                $(this).addClass('less');
            }
        });
    }
})(jQuery);