(function ($) {
    'use strict';

    const jobapply_info = $('#jobapply_info'),
        form_uploadjobdescription = $('form.upload_job_description-form');
    if (jobapply_info) {
        jobapply_info.find('.jobapply_info-action').on('click', function() {
            var toggle = jobapply_info.find('.jobapply_info-toggles input:checked').val();
            if (!$(this).hasClass('next')) {
                toggle = 'apply_root';
            }
            jobapply_info.find(`.jobapply_info-item[role="${toggle}"]`).addClass('active').siblings().removeClass('active');
        });
    }

    const sjbApplicationForm = $('#sjb-application-form');
    if (sjbApplicationForm) {
        var appSubmit = sjbApplicationForm.find('.app-submit'),
            loadingForm = sjbApplicationForm.find('.sjb-loading');

        if (appSubmit.attr('disabled') && appSubmit.attr('disabled') == 'disabled') {
            loadingForm.hide();
        }
    }

        $(document).on('click', '.form-field.upload-file .uploadfile-list > a', function() {
            var wrapper = $(this).closest('.uploadfile-list'),
                uploadfileWrapper = wrapper.find('.uploadfile-wrapper');
            
            if (uploadfileWrapper.is(":visible")) {
                uploadfileWrapper.slideUp(300);
                wrapper.removeClass('show');
            } else {
                uploadfileWrapper.slideDown(300);
                wrapper.addClass('show');
            }
        });

        $(document).on('change', '.form-field.upload-file input[type="file"]', function() {
            var wrapper = $(this).closest('.uploadfile-list'),
                uploadfileWrapper = wrapper.find('.uploadfile-wrapper'),
                filesChoosed = wrapper.find('.files-choosed');

            filesChoosed.html('');
            for (let i = 0; i < $(this).get(0).files.length; ++i) {
                filesChoosed.append(
                    `<div class="file-item">
                        <span class="file-name">${$(this).get(0).files[i].name}</span>
                        <span class="file-action"></span>
                        <div class="file-options">
                            <a class="remove" href="javascript:void(0)" title="">Remove</a>
                        </div>
                    </div>`
                );
            }
            if ($(this).get(0).files.length > 0) {
                wrapper.addClass('has-filed');
            }
            uploadfileWrapper.slideUp(300);
            wrapper.removeClass('show');
        });

        $(document).on('click', '.form-field.upload-file .files-choosed .file-action', function() {
            $(this).closest('.file-item').toggleClass('opened');
        });

        $(document).on('click', '.form-field.upload-file .files-choosed .file-options > a', function() {
            var wrapper = $(this).closest('.uploadfile-list');

            if ($(this).hasClass('remove')) {
                $(this).closest('.file-item').remove();
                wrapper.find('input[type="file"]').val('');
            }
            if (wrapper.find('.files-choosed .file-item').length <= 0) {
                wrapper.removeClass('has-filed');
            }
        });
})(jQuery);