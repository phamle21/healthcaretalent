(function ($) {
    'use strict';

    const _JobDropwDownFilter = $('#job_dropdown_filters'),
        _LimitFilterItems = 10,
        siteURL = url => new URL(url),
        slugURL = url => new URL(url).pathname.match(/[^\/]+/g),
        paramsURL = (url, param = 'location') => new URL(url).searchParams.get(param);

    if (_JobDropwDownFilter) {
        var _FILTER = [];

        function updateFilterItem(tax, val) {
            if (_tried_filter_params && _tried_filter_params.includes(tax)) {
                var newVal = _FILTER[tax] ?? [];
                if (_FILTER[tax] && newVal.includes(val)) {
                    newVal = newVal.filter(item => item !== val);
                } else {
                    newVal.push(val);
                }
                _FILTER[tax] = newVal;
            }
        }

        initFilters();
        function initFilters() {
            if (_tried_filter_params) {
                _tried_filter_params.forEach(f => {
                    let parameter = paramsURL(window.location.href, f);
                    if (parameter != null) {
                        if (f == 'min_salary' || f == 'max_salary') {
                            $(`.togglefilter_jobs-item .slct-salary [name="${f}"]`).val(parameter);
                            _FILTER[f] = parameter;
                        } else {
                            let txtFilterSelected = [];
                            _FILTER[f] = parameter.split(',');
                            parameter.split(',').forEach(p => {
                                let filterdropdown = $(`.togglefilter_jobs-item .filterdropdown[data-tax="${f}"][data-value="${p}"]`);
                                filterdropdown.addClass('active');
                                if (p) txtFilterSelected.push(filterdropdown.find('span:eq(0)').text());
                            });
                            $(`.togglefilter_jobs-item > a[data-role="${f}"] .filterselected`).text(txtFilterSelected.join(', '));
                        }
                    }
                });
            }
        }
        
        _JobDropwDownFilter.find('.togglefilter_jobs-item .filterdropdown').on('click', function() {
            updateFilterItem($(this).attr('data-tax'), $(this).attr('data-value'));
            $(this).toggleClass('active');
            reloadParamOfPageURL();
        });

        function reloadParamOfPageURL() {
            var paramURL = '';
            if (_FILTER) {
                paramURL = Object.keys(_FILTER).map(key => `${key}=${_FILTER[key]}`).join('&');
            }
            window.location.href = _tried_site+'?'+paramURL;
        }

        _JobDropwDownFilter.find('.togglefilter_jobs-item .filterdropdown-reset').on('click', function() {
            window.location.href = _tried_site;
        });

        _JobDropwDownFilter.find('.submit_salary .salary_filter').on('click', function() {
            var wrapperSalary = $(this).closest('.year-salary-region'),
                minSalary = wrapperSalary.find('[name="min_salary"]'),
                maxSalary = wrapperSalary.find('[name="max_salary"]');
            
            _FILTER['min_salary'] = minSalary.val();
            _FILTER['max_salary'] = maxSalary.val();
            reloadParamOfPageURL();
        });


        _JobDropwDownFilter.find('.togglefilter_jobs-item > a').on('click', function() {
            console.log('a');
            var togglefilter_jobsCurrent = $(this).parent(),
                countItem = togglefilter_jobsCurrent.find('.togglefilter-context > ul > li').length;
    
            if (countItem > _LimitFilterItems) {
                togglefilter_jobsCurrent.find('.togglefilter-context > a').show();
            }

            if (togglefilter_jobsCurrent.hasClass('toggled')) {
                togglefilter_jobsCurrent.find('.togglefilter-context').slideUp(300).removeClass('showmore');
                togglefilter_jobsCurrent.removeClass('toggled');
            } else {
                togglefilter_jobsCurrent.find('.togglefilter-context').slideDown(300);
                togglefilter_jobsCurrent.addClass('toggled');
            }
        });
        _JobDropwDownFilter.find('.togglefilter_jobs-item .togglefilter-context > a').on('click', function() {
            var wrapper = $(this).closest('.togglefilter-context');

            if (wrapper.hasClass('showmore')) {
                wrapper.removeClass('showmore');
            } else {
                wrapper.addClass('showmore');
            }
        });
    }
})(jQuery);