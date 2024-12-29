(function($) {
    'use strict';

    var eldoms = $('#eldoms'),
        elements_frame = $('#frame-elblocks'),
        elements_frame_form = elements_frame.find('form#frame-elblocks-form'),
        elements_frame_context = elements_frame.find('#element-context'),
        elements_frame_action = elements_frame.find('#element-action'),
        elements_frame_breadcrumbs = elements_frame.find('.breadcrumbs'),
        element_elblocks = $('#element-elblocks'),
        enable_elements_frame = true,
        modal_elblocks = $('#modal-elblocks');

    if (elements_frame.length > 0) {
        elements_frame.draggable({
            handle: ".header .top"
        });
    }

    eldoms.find('button').on('click', function() {
        var func = $(this).attr('data-action'),
            tar = $(this).attr('data-target');
            
        if (func) {
            if (tar === 'eldom') {
                switch (func) {
                    case 'mode':
                        let wrapper = $(this).closest('.eldom-item'),
                            poststuff = $('#poststuff');
                        if (poststuff.hasClass('mode-eipostcontent')) {
                            poststuff.removeClass('mode-eipostcontent');
                            wrapper.find('[name="mode_eipostcontent"]').val('0');
                            $(this).removeClass('active');
                        } else {
                            wrapper.find('[name="mode_eipostcontent"]').val('1');
                            poststuff.addClass('mode-eipostcontent');
                            $(this).addClass('active');
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    });

    $(document).on('click', '.handle-actions button', function() {
        var func = $(this).attr('data-action'),
            tar = $(this).attr('data-target');
            
        if (func) {
            if (tar === 'modal') {
                let modal_action = modal_elblocks.attr('data-action'),
                    modal_key = modal_elblocks.attr('data-key'),
                    modal_role = modal_elblocks.attr('data-role'),
                    modal_selector = '#element-elblocks .'+modal_role+'[data-key="'+modal_key+'"]';

                if (func === 'ok') {
                    if (modal_action && modal_role) {
                        if (modal_action == 'remove') {
                            $(modal_selector).remove();
                            if (element_elblocks.find('.'+modal_role+':not(.pattern)').length < 1) {
                                element_elblocks.find('.'+modal_role+'-wrapper').addClass('empty');
                            }
                        } else {
                            // coding
                        }
                    }
                }
                modal_elblocks.fadeOut();
                setTimeout(() => {
                    modal_elblocks.attr('data-action', false).attr('data-key', false).attr('data-role', false);
                }, 500);
            } else {
                let elblock = $(this).closest('.elblock'),
                    elcontext = false,
                    key = elblock.attr('data-key'),
                    elblock_index = elblock.index(),
                    role = 'elblock';

                switch (func) {
                    case 'up':
                        swapElements(element_elblocks.find('.'+role), elblock_index, elblock_index - 1, true);
                        break;
                    case 'down':
                        swapElements(element_elblocks.find('.'+role), elblock_index, elblock_index + 1);
                        break;
                    case 'view':
                        if ($(this).hasClass('none-visibility')) {
                            $(this).removeClass('none-visibility');
                            elblock.removeClass('hidden');
                            elblock.find('input.elblock-status').val('1');
                        } else {
                            $(this).addClass('none-visibility');
                            elblock.addClass('hidden');
                            elblock.find('input.elblock-status').val('0');
                        }
                        break;
                    case 'remove': case 'trash':
                        if ($(this).data('role') && $(this).data('role') === 'elcontext') {
                            role = 'elcontext';
                            key = $(this).closest('.elcontext').attr('data-key');
                        }
                        modal_elblocks.attr('data-key', key).attr('data-action', 'remove').attr('data-role', role).fadeIn();
                        break;
                    case 'html':
                        if ($(this).data('role') && $(this).data('role') === 'elcontext') {
                            elcontext = $(this).closest('.elcontext');
                            elcontext.toggleClass('sourcing');
                        }
                        break;
                    case 'edit':
                        if ($(this).data('role') && $(this).data('role') === 'elcontext') {
                            elcontext = $(this).closest('.elcontext');
                            render_elements_frame({
                                action: 'edit',
                                kblock: key,
                                kcontext: elcontext.attr('data-key'),
                                element: elcontext.find('[name="elcontext_type__'+key+'__'+elcontext.attr('data-key')+'"]').val(),
                                content: elcontext.find('[name="elcontext_content__'+key+'__'+elcontext.attr('data-key')+'"]').val(),
                                collapse: true
                            });
                        }
                        break;
                    default:
                        elblock.toggleClass('closed');
                        break;
                }
            }
        }
    });

    function swapElements(siblings, index, subindex, isbefore = false) {
        if (subindex < 1) return;
        var object = siblings.get(index),
            subject = $(siblings.get(subindex));

        if (isbefore) {
            subject.insertAfter(object);
        } else {
            subject.insertBefore(object);
        }
    }

    function convertToSlug(str) {
        return str.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
    }
    
    $(document).on('keyup', '.elblock input.elblock-heading', function() {
        var str = $(this).val(),
            elblock = $(this).closest('.elblock'),
            elanchor = elblock.find('.elanchor'),
            handle_title = elblock.find('.handle-title'),
            text_anchor = elblock.find('.text-anchor');

        setTimeout(() => {
            if (str || str.length != 0) {
                if (!elanchor.hasClass('saved')) {
                    handle_title.text(str);
                    elanchor.fadeIn(500);
                    if (text_anchor.text('')) {
                        text_anchor.text(convertToSlug(str));
                    }
                }
            } else {
                handle_title.text('');
            }
        }, 500);
    });
    
    $(document).on('click', '.elblock .text-anchor', function() {
        var elanchor = $(this).closest('.elanchor'),
            stranchor = $(this).text();

        elanchor.toggleClass('editing');
        elanchor.find('input.elblock-anchor').val(stranchor);
    });
    
    $(document).on('click', '.elblock .wrap-anchor a', function() {
        var elanchor = $(this).closest('.elanchor'),
            txtanchor = elanchor.find('.text-anchor'),
            editanchor = elanchor.find('input.elblock-anchor');

        if ($(this).attr('data-action') == 'save') {
            txtanchor.text(convertToSlug(editanchor.val()));
            elanchor.addClass('saved');
        }
        elanchor.removeClass('editing');
    });

    $(document).on('click', '.elinsertblock', function(e, args = Object) {
        var wrapper = element_elblocks.find('.elblock-wrapper'),
            key = crypto.randomUUID().substring(0, 6),
            pattern = wrapper.find('.elblock.pattern').clone().removeClass('pattern').attr('data-key', key),
            position = $(this).attr('data-position');

        pattern.find('.elblock-status').attr('name', 'elblock_status__'+key);
        pattern.find('.elblock-heading').attr('name', 'elblock_heading__'+key);
        pattern.find('.elblock-anchor').attr('name', 'elblock_anchor__'+key);
        if (position && position === 'top') {
            pattern.insertAfter($(this));
        } else {
            pattern.insertBefore($(this));
        }

        if (wrapper.hasClass('empty')) {
            wrapper.removeClass('empty');
        }
    });

    $(document).on('click', '#frame-elblocks .close, .elinsertelement', function() {
        if (elements_frame.is(":hidden")) {
            var args = {
                    kblock: false,
                    toposition: false,
                    action: 'insert',
                    collapse: true
                };
            
            if ($(this).closest('.elblock').attr('data-key')) {
                args.kblock = $(this).closest('.elblock').attr('data-key');
            }
            if ($(this).attr('data-position') && $(this).attr('data-position') === 'top') {
                args.toposition = true;
            }

            render_elements_frame(args);
        } else {
            elements_frame.fadeOut(500);
            restore_elements_frame_form();
        }
    });

    $(document).on('click', '#frame-elblocks .elements .item button:not(:disabled)', function(e) {
        var args = {
                direction: true,
                element: false
            };

        if ($(this).data('element')) {
            args.element = $(this).data('element');
        }
        render_elements_frame(args);
    });

    $(document).on('click', '#frame-elblocks .breadcrumbs a', function(e) {
        render_elements_frame({
            direction: true
        });
    });

    function render_elements_frame(args = Object) {
        var vdata = {
                action: 'elements_frame'
            },
            vload = element_elblocks;
            
        if (args.element) {
            vdata.element = args.element;
            if (args.content && args.content != '') {
                vdata.context = args.content;
            }
        }
        if ((args.element || args.direction) && !args.collapse) {
            vload = elements_frame;
        }

        if (args.direction || args.kblock && enable_elements_frame) {
            $.ajax({
                type: 'GET',
                url: ajaxurl,
                data: vdata,
                beforeSend: function() {
                    vload.addClass('loading');
                    elements_frame.find('.footer .status span').text('Đang tải...');
                    enable_elements_frame = false;
                },
                success: function(response) {
                    elements_frame_context.html('');
                    if (response.result) {
                        elements_frame_context.html(response.result);
                        elements_frame.find('.footer .status span').text('Tốt');

                        if (response.breadcrumbs) {
                            elements_frame_breadcrumbs.html(response.breadcrumbs);
                        }
                        if (response.message) {
                            elements_frame.find('.footer .message').text(response.message);
                        }
                        if (args.element) {
                            elements_frame_action.show();
                            elements_frame_form.find('input[name="type"]').val(args.element);
                            if (response.title && response.title != '') {
                                elements_frame_form.find('input[name="title"]').val(response.title);
                            }
                        } else {
                            elements_frame_action.hide();
                        }
                        if (args.action && args.action === 'edit') {
                            elements_frame_form.find('input[name="action"]').val('edit');
                            if (args.kcontext) {
                                elements_frame_form.find('input[name="elcontext"]').val(args.kcontext);
                            }
                            if (args.content && args.content != '') {
                                preload_frame_elblocks_form(args.element, args.content);
                            }
                        } else {
                            if (args.toposition) {
                                elements_frame_form.find('input[name="toposition"]').val(true);
                            }
                        }
                        if (args.kblock) {
                            elements_frame_form.find('input[name="elblock"]').val(args.kblock);
                        }
                    } else {
                        console.log('Có lỗi xảy ra!');
                        elements_frame.find('.status span').text('Không tốt');
                    }
                },
                complete: function(response) {
                    vload.removeClass('loading');
                    if (elements_frame.is(":hidden") && args.collapse) {
                        elements_frame.fadeIn(500);
                    }
                    if (response.status != 200) {
                        elements_frame.find('.status span').text('Xảy ra lỗi');
                    }
                    if (args.element) {
                        init_libs({
                            trumbowyg: true
                        }, args.element);
                    }
                    enable_elements_frame = true;
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            });
        }
    }

    function restore_elements_frame_form() {
        elements_frame_form.find('input[name="action"]').val('insert');
        elements_frame_form.find('input[name="type"]').val('paragraph');
        elements_frame_form.find('input[name="title"]').val(false);
        elements_frame_form.find('input[name="elblock"]').val(false);
        elements_frame_form.find('input[name="elcontext"]').val(false);
        elements_frame_form.find('input[name="toposition"]').val(false);
    }

    $(document).on('submit', '#frame-elblocks form#frame-elblocks-form', function(e) {
        e.preventDefault();
        var args = {
                action: 'insert',
                kblock: false,
                kcontext: false,
                toposition: false,
                title: false,
                type: 'paragraph',
                content: '',
            },
            elblock = elements_frame_form.find('[name="elblock"]'),
            elcontext = elements_frame_form.find('[name="elcontext"]'),
            type = elements_frame_form.find('[name="type"]'),
            content = elements_frame_form.find('[name="content"]'),
            title = elements_frame_form.find('input[name="title"]'),
            action = elements_frame_form.find('input[name="action"]'),
            toposition = elements_frame_form.find('input[name="toposition"]');
        
        if (elblock && elblock.val() != '') {
            args.kblock = elblock.val();
        }
        if (title && title.val() != '') {
            args.title = title.val();
        }
        if (type && type.val() != '') {
            args.type = type.val();
        }
        if (content && content.val() != '') {
            args.content = presubmit_frame_elblocks_form(type.val(), content.val());
        }

        if (enable_elements_frame) {
            enable_elements_frame = false;
            if (action && action.val() == 'edit') {
                args.action = action.val();
                if (elcontext && elcontext.val() != '') {
                    args.kcontext = elcontext.val();
                }
                update_element_item(args);
            } else {
                if (toposition && toposition.val() === 'true') {
                    args.toposition = true;
                }
                render_element_item(args);
            }
        }
        enable_elements_frame = true;
        elements_frame.fadeOut(500);
        restore_elements_frame_form();
    });

    function update_element_item(args = Object) {
        var elblock = $('.elblock[data-key="'+args.kblock+'"]'),
            elcontext = elblock.find('.elcontext[data-key="'+args.kcontext+'"]');

        if (elcontext.length > 0) {
            if (args.type && args.type != '') {
                let srcimg = elcontext.find('.icon-elcontext').attr('src'),
                    originimg = elcontext.find('.icon-elcontext').data('origin'),
                    extimg = srcimg.substr(srcimg.lastIndexOf('.'));
                    elcontext.find('.icon-elcontext').attr('src', originimg+args.type+extimg);
                if (args.title && args.title != '') {
                    elcontext.find('.title-elcontext').text(args.title);
                }
                elcontext.find('[name="elcontext_type__'+args.kblock+'__'+args.kcontext+'"]').val(args.type);
            }
            if (args.content && args.content != '') {
                elcontext.find('[name="elcontext_content__'+args.kblock+'__'+args.kcontext+'"]').val(args.content);
                elcontext.find('.layout-elcontext').html(args.content);
            }
        }
    }

    function render_element_item(args = Object) {
        var elblock = false,
            key = false,
            pattern = false;

        if (args.kblock && args.kblock != '') {
            elblock = element_elblocks.find('.elblock[data-key="'+args.kblock+'"]');
            key = crypto.randomUUID().substring(0, 6);
            pattern = elblock.find('.elcontext.pattern').clone().removeClass('pattern').attr('data-key', key);
        }
        if (pattern && elblock.length > 0) {
            pattern.find('.elcontext-type').attr('name', 'elcontext_type__'+elblock.data('key')+'__'+key);
            pattern.find('.elcontext-content').attr('name', 'elcontext_content__'+elblock.data('key')+'__'+key);

            if (args.type && args.type != '') {
                let srcimg = pattern.find('.icon-elcontext').attr('src'),
                    originimg = pattern.find('.icon-elcontext').data('origin'),
                    extimg = srcimg.substr(srcimg.lastIndexOf('.'));
                pattern.find('.icon-elcontext').attr('src', originimg+args.type+extimg);
                if (args.title && args.title != '') {
                    pattern.find('.title-elcontext').text(args.title);
                }
                pattern.find('[name="elcontext_type__'+args.kblock+'__'+key+'"]').val(args.type);
            }
            if (args.content && args.content != '') {
                pattern.find('[name="elcontext_content__'+args.kblock+'__'+key+'"]').val(args.content);
                pattern.find('.layout-elcontext').html(args.content);
            }
            if (args.toposition) {
                pattern.insertAfter(elblock.find('.elinsertelement[data-position="top"]'));
            } else {
                pattern.insertBefore(elblock.find('.elinsertelement:not([data-position="top"])'));
            }

            if (elblock.find('.elcontext-wrapper').hasClass('empty')) {
                elblock.find('.elcontext-wrapper').removeClass('empty');
            }
        }
    }

    function preload_frame_elblocks_form(type, content) {
        let reg_exp = `<!--${type} ([^)]+)\-->`,
            matches = new RegExp(reg_exp, 'g').exec(content),
            context = content.replace(new RegExp(reg_exp, 'g'), '');

        if (type === 'heading') {
            reg_exp = `<${matches[1]}>|</${matches[1]}>`;
            context = context.replace(new RegExp(reg_exp, 'g'), '');
            
            elements_frame_form.find('[name="level"]').val(matches[1]).change();
            elements_frame_form.find('[name="heading"]').val(context);
        } else if (type === 'code') {
            reg_exp = `<div class="code-element"><pre><code>|</pre></code></div>`;
            context = content.replace(new RegExp(reg_exp, 'g'), '');
            
            elements_frame_form.find('[name="content"]').val(context);
        } else if (type === 'table') {
            reg_exp = `<div class="table-element"><pre><code>|</pre></code></div>`;
            context = content.replace(new RegExp(reg_exp, 'g'), '');
            
            elements_frame_form.find('[name="content"]').val(context);
        } else if (type === 'note') {
            reg_exp = `<div class="note-element ${matches[1]}">|</div>`;
            context = context.replace(new RegExp(reg_exp, 'g'), '');

            elements_frame_form.find('[name="kind"]').val(matches[1]).change();
            elements_frame_form.find('[name="content"]').val(context);
        } else {
            elements_frame_form.find('[name="content"]').val(content);
        }
    }

    function presubmit_frame_elblocks_form(type, content) {
        if (type === 'heading') {
            let heading = elements_frame_form.find('[name="heading"]').val(),
                level = elements_frame_form.find('[name="level"]').val();
            
            if (!level) level = 'h4';
            content = `<!--heading ${level}--><${level}>${heading}</${level}>`;
        } else if (type === 'code') {
            content = `<div class="code-element"><pre><code>${content}</pre></code></div>`;
        } else if (type === 'table') {
            content = `<div class="table-element">${content}</div>`;
        } else if (type === 'note') {
            let kind = elements_frame_form.find('[name="kind"]').val();
            
            if (!kind) kind = 'attention';
            content = `<!--note ${kind}--><div class="note-element ${kind}">${content}</div>`;
        }
        return content;
    }

    function init_libs(args = Object, element = false) {
        var parameters = {
            semantic: {
                'b': 'strong',
                'i': 'em',
                's': 'del',
                'strike': 'del',
                'div': 'p'
            },
            tagsToRemove: ['script', 'link'],
            defaultLinkTarget: '_blank',
            linkTargets: ['_blank', '_self', '_parent', '_top'],
            btnsDef: {
                blockquote: {
                    fn: function () { return true; },
                    tag: 'blockquote',
                    title: 'Blockquote',
                    isSupported: function () { return true; },
                    key: 'b',
                    param: '' ,
                    forceCSS: false,
                    class: '',
                    hasIcon: true
                }
            }
        };

        if (args) {
            if (args.trumbowyg) {
                switch (element) {
                    case 'quote':
                        parameters.btns = [
                            ['blockquote'],
                            ['strong', 'em', 'del'],
                            ['superscript', 'subscript'],
                            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                            ['unorderedList', 'orderedList'],
                            ['horizontalRule'],
                            ['removeformat'],
                            ['viewHTML']
                        ];
                        break;
                    case 'code':
                        parameters.btns = [
                            ['strong', 'em', 'del'],
                            ['unorderedList'],
                            ['foreColor', 'backColor'],
                            ['removeformat'],
                            ['viewHTML']
                        ];
                        break;
                    case 'noteimportant':
                        parameters.btns = [
                            ['strong', 'em', 'del'],
                            ['foreColor', 'backColor'],
                            ['removeformat'],
                            ['viewHTML']
                        ];
                        break;
                    case 'table':
                        parameters.btns = [
                            ['table'],
                            ['strong', 'em', 'del'],
                            ['foreColor', 'backColor'],
                            ['removeformat'],
                            ['viewHTML']
                        ];
                        break;
                    default:
                        parameters.btns = [
                            // ['formatting'],
                            ['blockquote'],
                            ['strong', 'em', 'del'],
                            ['superscript', 'subscript'],
                            ['foreColor', 'backColor'],
                            ['link'],
                            ['insertImage'],
                            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                            ['unorderedList', 'orderedList'],
                            ['horizontalRule'],
                            ['undo', 'redo'], // Only supported in Blink browsers
                            ['removeformat'],
                            ['viewHTML']
                        ];
                        break;
                }
                $('textarea.trumbowyg-edior').trumbowyg(parameters);
            }
        }
    }

    // elframe
    $(document).on('change', '#frame-elblocks .element-wrap[data-element="heading"] [name="level"]', function() {
        var tag = 'h4';
        if ($(this).val() != '') {
            tag = $(this).val();
        }
        elements_frame_context.find('.heading-preview').attr('data-tag', tag);
    });
})(jQuery);
