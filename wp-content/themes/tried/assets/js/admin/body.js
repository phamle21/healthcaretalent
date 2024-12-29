jQuery(function($) {
	"use strict";

    const API = '//www.phuongtung.com/info/wp-json/tried/v1',
        manage_tried = $('#manage-tried-tcdm');

    if (manage_tried) {
        var table_manage = manage_tried.find('table.table-manage-tried-tcdm'),
            modal_addnew = manage_tried.find('#modal-addnew_tcdm'),
            modal_detail = manage_tried.find('#modal-detail_tcdm'),
            modal_notify = manage_tried.find('#modal-notify_tcdm');

        $(document).on('change', '.inline-fieldset .input-field[role="type"]', function() {
            var wrapper = $(this).closest('.inline-fieldwrapper');
            switch ($(this).val()) {
                case '0':
                    wrapper.find('.inline-fieldsetlegend.olddevicetype').slideDown(500);
                    wrapper.find('.inline-fieldsetgroup.olddevicetype').slideDown(500);
                    wrapper.find('.inline-fieldsetlegend.newdevicetype').slideUp(500);
                    wrapper.find('.inline-fieldsetgroup.newdevicetype').slideUp(500);
                    break;
                case '1':
                    wrapper.find('.inline-fieldsetlegend.olddevicetype').slideDown(500);
                    wrapper.find('.inline-fieldsetgroup.olddevicetype').slideDown(500);
                    wrapper.find('.inline-fieldsetlegend.newdevicetype').slideDown(500);
                    wrapper.find('.inline-fieldsetgroup.newdevicetype').slideDown(500);
                    break;
                default:
                    wrapper.find('.inline-fieldsetlegend.olddevicetype').slideUp(500);
                    wrapper.find('.inline-fieldsetgroup.olddevicetype').slideUp(500);
                    wrapper.find('.inline-fieldsetlegend.newdevicetype').slideUp(500);
                    wrapper.find('.inline-fieldsetgroup.newdevicetype').slideUp(500);
                    break;
            }
        });

        $(document).on('click', `table.table-manage-tried-tcdm tr .row-actions a, table.table-manage-tried-tcdm tr.inline-edit-row button.cancel`, function() {
            var itemid = $(this).attr('data-itemid');
            if ($(this).hasClass('cancel')) {
                $(this).closest('tr').removeClass('editting');
            } else if ($(this).hasClass('detail')) {
                loadDetailTCDM(itemid);
            } else {
                table_manage.find('tr.inline-edit-row.itemid-'+itemid).toggleClass('editting').siblings().removeClass('editting');
                if (table_manage.find('tr.inline-edit-row.itemid-'+itemid).hasClass('editting')) {
                    loadEditingTCDM(itemid);
                }
            }
        });

        function loadEditingTCDM(itemid) {
            if (itemid) {
                var wrapper = table_manage.find('tr.inline-edit-row.itemid-'+itemid),
                    keys = [
                        'seller_customer', 'seller_phone', 'device_title', 
                        'device_ntitle', 'note', 'device_imei', 
                        'device_nimei', 'price_purchase', 'price_renewal', 
                        'price_support', 'price_sale', 'tcdm_id', 
                        'user_created', 'type', 'price_reference', 'store'
                    ];

                $.ajax({
                    type: "GET",
                    url: API+`/tcdm-detail/${itemid}`,
                    beforeSend: function() {
                        manage_tried.addClass('proccessing');
                    },
                    success: function(res) {
                        if (res.result) {
                            keys.forEach(k => {
                                let kinput = wrapper.find(`.input-field[role="${k}"]`);
                                if (typeof res.result[k] != 'undefined') {
                                    kinput.val(res.result[k]);
                                    if (k == 'type') kinput.trigger('change');
                                    if (k == 'user_created' && !kinput.find(`option[value="${res.result[k]}"]`).val()) kinput.val('');
                                }
                            });

                            let olddevicetype = wrapper.find('.olddevicetype .inline-fieldset .input-wrap.olddevice'),
                                newdevicetype = wrapper.find('.newdevicetype .inline-fieldset .input-wrap.newdevice');

                            olddevicetype.addClass('choosed');
                            olddevicetype.find('span.text-field').html( 
                                `${res.result['device_title']}
                                <input type="hidden" class="input-field" role="device_status" value="${res.result['device_status']}"/>`
                            );
                            olddevicetype.find('.statusdevice').html(
                                `<label for="optstatus-0">
                                    ${res.result['device_status']}<br>
                                    <i>Giá tham khảo: <span>${res.result['price_reference']}₫</span></i>
                                </label>`
                            );
                            if (res.result.type && res.result.type === '1') {
                                newdevicetype.addClass('choosed');
                                newdevicetype.find('span.text-field').html(
                                    `${res.result['device_ntitle']} <em>(Giá máy: <span class="text-red">${res.result['price_renewal']}₫</span>)</em>
                                    <input type="hidden" class="input-field" role="price_renewal" value="${res.result['price_renewal']}"/>`
                                );
                            } else {
                                wrapper.find(`.input-field[role="device_ntitle"]`).val('');
                                wrapper.find(`.input-field[role="device_nimei"]`).val('');
                                wrapper.find(`.input-field[role="price_sale"]`).val('');
                                wrapper.find(`.input-field[role="price_support"]`).val('');
                            }
                        } else {
                            console.log( 'Có lỗi xảy ra!' );
                        }
                    },
                    complete: function() {
                        manage_tried.removeClass('proccessing');
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                });
            }
        }

        function loadDetailTCDM(itemid = false) {
            if (itemid) {
                $.ajax({
                    type: "GET",
                    url: API+`/tcdm-detail/${itemid}`,
                    beforeSend: function() {
                        manage_tried.addClass('proccessing');
                    },
                    success: function(res) {
                        if (res.result) {
                            var keys = [
                                'seller_customer', 'seller_phone', 'device_title', 
                                'device_ntitle', 'device_status', 'note', 'device_imei', 
                                'device_nimei', 'price_purchase', 'price_renewal', 
                                'price_support', 'price_sale', 'created_at', 'tcdm_id', 
                                'shop_phone', 'shop_address', 'shop_title', 'price_totalword', 
                                'user_confirmed', 'user_expertise', 'user_created'
                            ];

                            keys.forEach(k => {
                                if (typeof res.result[k] != 'undefined') {
                                    modal_detail.find(`.field[role="${k}"]`).text(res.result[k]);
                                    if (k == 'user_created' || k == 'user_confirmed') {
                                        modal_detail.find(`.field[role="${k}"]`).text(res.result[k].split(' - ')[0]);
                                    }
                                }
                            });

                            modal_detail.find(`.field[role="price_total"]`).text(new Intl.NumberFormat().format(res.result['price_total']).replaceAll('.', ','));
                            if (res.result['type'] && res.result['type'] == 1) {
                                modal_detail.find('.textnewdevice.decfinal').text('6 = 4 - (2 + 3) - 5');
                                modal_detail.find('.textnewdevice.pricefinal').text('Giá bù chênh lệch');
                            } else {
                                modal_detail.find('.field[role="price_support"]').text('0');
                                modal_detail.find('.textnewdevice.decfinal').text('4 = 2 - 3');
                                modal_detail.find('.textnewdevice.pricefinal').text('Giá thu cuối');
                            }

                            modal_detail.find('.newdevice').each(function() {
                                $(this).hide();
                                if (res.result['type'] && res.result['type'] == 1) {
                                    $(this).show();
                                }
                            });
                            if (res.result['status'] == 1) {
                                modal_detail.find('.action .print').show().attr('data-id', res.result['tcdm_id']);
                            } else {
                                modal_detail.find('.action .print').hide();
                            }
                        } else {
                            console.log( 'Có lỗi xảy ra!' );
                        }
                    },
                    complete: function() {
                        manage_tried.removeClass('proccessing');
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                });
            }
        }

        $(document).on('click', 'table.table-manage-tried-tcdm tr.inline-row .button-tcdm_action', function() {
            if ($(this).attr('data-target')) {
                modal_notify.find('form.modal-form [name="tcdm_id"]').val($(this).attr('data-itemid'));
            } else {
                $(this).closest('tr.inline-row').find('a.detail').trigger('click');
            }
        });

        $(document).on('click', '#modal-notify_tcdm .cancel', function() {
            $(this).closest('.modal-tried').removeClass('opened');
        });

        $(document).on('click', '#modal-addnew_tcdm .cancel', function() {
            modal_addnew.find('form')[0].reset();
            modal_addnew.find('[name="type"]').trigger('change');
            $(this).closest('.modal-tried').removeClass('opened');
        });

        $(document).on('dblclick', '.inline-fieldset.choosefield .input-wrap', function() {
            if ($(this).hasClass('choosed')) {
                $(this).find('span.text-field').removeClass('active');
                $(this).removeClass('choosed');
            }
        });

        $(document).on('click', '.inline-fieldset.choosefield input.input-field', function() {
            var parent = $(this).parent();
            parent.find('.choosefield-field').slideDown(300);
            parent.addClass('opened');
        });

        $(document).on('keyup', '.inline-fieldset.choosefield .input-field', function() {
            var parent = $(this).parent(),
                search = $(this).val().toLowerCase();

            parent.find('.choosefield-field a').each(function() {
                $(this).show();
                if($(this).text().toLowerCase().indexOf(search) < 0) $(this).hide();
            });

            if (search.length > 3 && $(this).closest('.inline-fieldset').hasClass('newdevice')) {
                parent.find('.choosefield-field').html('');
                setTimeout(function() {
                    $.ajax('//phuongtung.vn/api/v1/products', {
                        type: 'GET',
                        data: {
                            page: 1,
                            name: search,
                            sort_key: 'price_high_to_low',
                            with_variant: true
                        },
                        headers: {
                            'Authorization': 'd0001f16afcc8cc8e1505dac70dc0709',
                            'Access-Control-Allow-Origin': '*'
                        },
                        beforeSend: function() {
                            manage_tried.addClass('proccessing');
                        },
                        success: function(rs) {
                            if ( typeof rs.data.data !== 'undefined' ) {
                                var data = rs.data.data;
                                if ( data && data.length > 0 ) {
                                    var htmlChoosefield = '';
                                    data.forEach(p => {
                                        htmlChoosefield += `<a href="javascript:void(0)" data-prod_id="${p.id}">${p.name}</a>`;
                                    });
                                    parent.find('.choosefield-field').html( htmlChoosefield );
                                } else {
                                    parent.find('.choosefield-field').html('<p class="not-found">Không tìm thấy kết quả!</p>');
								    console.log('Không có kết quả trả về!');
                                }
                            } else {
                                parent.find('.choosefield-field').html('<p class="not-found">Không tìm thấy kết quả!</p>');
                                console.log('Phát sinh lỗi!');
                            }
                        },
                        complete: function() {
                            manage_tried.removeClass('proccessing');
                        },
                        error: function( jqXHR, textStatus, errorThrown ) {
                            console.log( 'The following error occured: ' + textStatus, errorThrown );
                        }
                    });
                }, 500);
            }
        });

        $(document).on('click', '.inline-fieldset.choosefield .choosefield-field a', function() {
            var root = $(this).closest('.inline-fieldwrapper'),
                wrapper = $(this).closest('.inline-fieldset'),
                choosedShow = wrapper.find('span.text-field'),
                valProd_id = $(this).attr('data-prod_id'),
                valTitle = $(this).text();

            wrapper.find('.choosefield-field').slideUp(300);
            wrapper.find('.input-wrap').removeClass('opened');
            choosedShow.text('');
            if (!choosedShow.hasClass('active')) choosedShow.addClass('active');
            if (!wrapper.find('.input-wrap').hasClass('choosed')) wrapper.find('.input-wrap').addClass('choosed');
            setTimeout(function() {
                choosedShow.text(valTitle);
                if (valProd_id) {
                    if (wrapper.hasClass('newdevice')) {
                                $.ajax({
                                    type: "GET",
                                    url: `https://www.phuongtung.vn/api/v1/products/detail/${valProd_id}`,
                                    headers: {
                                        'Authorization': 'd0001f16afcc8cc8e1505dac70dc0709',
                                        'Access-Control-Allow-Origin': '*'
                                    },
                                    beforeSend: function() {
                                        manage_tried.addClass('proccessing');
                                        root.find('[name="price_renewal"]').val('');
                                        root.find('.choosefield-field.attrdevice').html('');
                                    },
                                    success: function(response) {
                                        var data = response.data;
                                        if (typeof data != 'undefined' && data!= '') {
                                            var options = {},
                                                variations = data.variations,
                                                title = data.name;

                                            if ( data.options && data.options.length > 0 ) {
                                                data.options.forEach(op => {
                                                    if (op.values && op.values.length > 0) {
                                                        op.values.forEach(opval => {
                                                            if (opval.id) options[opval.id] = opval.name;
                                                        });
                                                    }
                                                });
                                            }

                                            if (variations && variations.length > 0) {
                                                variations.forEach((v, y) => {
                                                    let vprice = new Intl.NumberFormat().format(v.product_price),
                                                        vpricesale = false,
                                                        vpvariant = [],
                                                        vnamevariant = [];

                                                    if (v.value && v.value != '') {
                                                        vpvariant = v.value .split(',');
                                                        vpvariant[0] = vpvariant[0].substring(1);
                                                        vpvariant[vpvariant .length - 1] = vpvariant[vpvariant.length - 1].substring(0, vpvariant[vpvariant.length - 1].length - 1);
                                                        vpvariant.forEach((x, i) => {
                                                            vpvariant[i] = vpvariant [i].includes('"') ? vpvariant[i].replaceAll('"', '').trim():vpvariant[i].replaceAll("'", '').trim();
                                                        });
                                                    }
                                                    
                                                    if (vpvariant && vpvariant.length > 0) {
                                                        for (const [kop, vop] of Object.entries(options)) {
                                                            if (vpvariant.includes(kop)) {
                                                                vnamevariant.push(vop);
                                                            }
                                                        }
                                                    }

                                                    if (vnamevariant && vnamevariant.length > 0) {
                                                        title = `${data.name} (${vnamevariant.join(' - ')})`;
                                                    }
                                                    
                                                    if (v.product_sale_price && v.product_sale_price != 0) {
                                                        vprice = new Intl.NumberFormat().format(v.product_sale_price);
                                                        vpricesale = new Intl.NumberFormat().format(v.product_price);
                                                    }

                                                    root.find('.choosefield-field.attrdevice').append(
                                                        `<input id="optattrdevice-${y}" type="radio" class="input-field" name="price_renewal" role="price_renewal" data-title="${title}" value="${vprice}" ${y==0?'checked':''}>
                                                        <label for="optattrdevice-${y}">
                                                            <strong>${title}</strong><br>
                                                            <i>Giá bán: <span>${vprice}₫</span> <del>${vpricesale?vpricesale+'đ':''}</del></i>
                                                        </label>`
                                                    );
                                                });
                                            } else {
                                                let price = new Intl.NumberFormat().format(data.price),
                                                    pricesale = 0;

                                                if ( data.sale_price && data.sale_price != 0 ) {
                                                    price = new Intl.NumberFormat().format(data.sale_price);
                                                    pricesale = new Intl.NumberFormat().format(data.price);
                                                }

                                                root.find('.choosefield-field.attrdevice').append(
                                                    `<input id="optattrdevice-1" type="radio" class="input-field" name="price_renewal" role="price_renewal" data-title="${title}" value="${price}" checked>
                                                    <label for="optattrdevice-1">
                                                        <strong>${title}</strong><br>
                                                        <i>Giá bán: <span>${price}₫</span> <del>${pricesale?pricesale+'đ':''}</del></i>
                                                    </label>`
                                                );
                                            }

                                            root.find('[name="device_nimei"], [role="device_nimei"]').val('');
                                            root.find('[name="price_sale"], [role="price_sale"]').val('');
                                            root.find('[name="device_ntitle"], [role="device_ntitle"]').val(function() {
                                                return root.find('[name="price_renewal"]:checked').attr('data-title');
                                            });
                                        } else {
                                            console.log( 'Có lỗi xảy ra!' );
                                        }
                                    },
                                    complete: function() {
                                        if (!root.find('.input-field[name="device_nimei"]').is('[disabled=disabled]')) root.find('.input-field[name="device_nimei"]').prop("disabled", false);
                                        if (!root.find('.input-field[name="price_renewal"]').is('[disabled=disabled]')) root.find('.input-field[name="price_renewal"]').prop("disabled", false);
                                        if (root.find('.inline-fieldset.attrdevice').is(":hidden")) root.find('.inline-fieldset.attrdevice').slideDown(300);
                                        wrapper.find('.choosefield-field').html('');
                                        manage_tried.removeClass('proccessing');
                                    },
                                    error: function( jqXHR, textStatus, errorThrown ) {
                                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                                    }
                                });
                    } else {
                            $.ajax({
                                type: "GET",
                                url: API+`/tcdm/?id=${valProd_id}`,
                                beforeSend: function() {
                                    manage_tried.addClass('proccessing');
                                    root.find('.inline-fieldset .statusdevice').html('');
                                },
                                success: function(response) {
                                    if (response.result && response.result.length > 0) {
                                        response.result[0].terms_status.forEach((st, k) => {
                                            if (k === 0) {
                                                root.find('[role="price_reference"], [name="price_reference"]').val(response.result[0].price[st.term_id]);
                                            }
                                            
                                            root.find('.inline-fieldset .statusdevice').append(
                                                `<input id="optstatus-${k}" type="radio" class="input-field" name="device_status" role="device_status" value="${st.description}" data-price_reference="${response.result[0].price[st.term_id]}" ${k == 0?'checked':''}>
                                                <label for="optstatus-${k}">
                                                    <strong>${st.name}</strong>: ${st.description}<br/>
                                                    <i>Giá tham khảo: <span>${response.result[0].price[st.term_id]}₫</span></i>
                                                </label>`
                                            );
                                        });

                                        root.find('[role="price_purchase"], [name="price_purchase"]').val('');
                                        root.find('[role="device_imei"], [name="device_imei"]').val('');
                                        root.find('[role="device_title"], [name="device_title"]').val(response.result[0].title);
                                        root.find('[role="price_support"], [name="price_support"]').val(response.result[0].pricesupport);
                                    } else {
                                        console.log( 'Có lỗi xảy ra!' );
                                        root.find('.inline-fieldset .statusdevice').html('<p class="not-found">Không tìm thấy kết quả!</p>');
                                    }
                                    root.find('.inline-fieldset .statusdevice').show();
                                },
                                complete: function() {
                                    if (!root.find('.input-field[name="device_imei"]').is('[disabled=disabled]')) root.find('.input-field[name="device_imei"]').prop("disabled", false);
                                    if (!root.find('.input-field[name="price_purchase"]').is('[disabled=disabled]')) root.find('.input-field[name="price_purchase"]').prop("disabled", false);
                                    if (!root.find('.input-field[name="note"]').is('[disabled=disabled]')) root.find('.input-field[name="note"]').prop("disabled", false);
                                    manage_tried.removeClass('proccessing');
                                },
                                error: function( jqXHR, textStatus, errorThrown ) {
                                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                                }
                            });
                    }
                }
            }, 500);
        });

        $(document).on('change', '.inline-fieldset.attrdevice [name="price_renewal"]', function() {
            $(this).closest('.inline-fieldwrapper').find('[role="device_ntitle"]').val($(this).attr('data-title'));
            $(this).closest('.inline-fieldwrapper').find('[role="device_nimei"]').val('');
            $(this).closest('.inline-fieldwrapper').find('[role="price_sale"]').val('');
        });
        $(document).on('change', '.inline-fieldset.statusdevice [name="device_status"]', function() {
            $(this).closest('.inline-fieldwrapper').find('[role="price_reference"]').val($(this).attr('data-price_reference'));
            $(this).closest('.inline-fieldwrapper').find('[role="device_imei"]').val('');
            $(this).closest('.inline-fieldwrapper').find('[role="price_purchase"]').val('');
        });

        $(document).on('submit', '#modal-addnew_tcdm form.modal-form', function(e) {
            e.preventDefault();
            var modalForm = modal_addnew.find('form.modal-form'),
                formData = new FormData(e.target),
                func = 'insert',
                isError = false;

            if (formData) {
                let args = {
                        seller_customer: formData.get('seller_customer'),
                        seller_phone: formData.get('seller_phone'),
                        type: formData.get('type'),
                        store: formData.get('store'),
                        note: formData.get('note'),
                        device_title: formData.get('device_title'),
                        device_status: formData.get('device_status'),
                        price_reference: formData.get('price_reference'),
                        device_imei: formData.get('device_imei'),
                        price_purchase: formData.get('price_purchase'),
                        user_created: formData.get('user_created')
                    };
                    
                if (args.type === 1 || args.type === '1') {
                    args.device_ntitle = formData.get('device_ntitle');
                    args.device_nimei = formData.get('device_nimei');
                    args.price_renewal = formData.get('price_renewal');
                    args.price_sale = formData.get('price_sale');
                    args.price_support = formData.get('price_support');
                }
                if (formData.get('func') && formData.get('func') != '') {
                    func = formData.get('func');
                }
                
                if (!isError) {
                    let datafields = {
                        action: 'tried_update_tcdm',
                        role: func,
                        data: Object.assign({}, args)
                    };

                    $.ajax({
                        type: "POST", 
                        url: ajaxurl, 
                        data: datafields,
                        beforeSend: function() {
                            manage_tried.addClass('proccessing');
                            modalForm.find('.notice').hide();
                            modalForm.find('.notice .error').html('');
                        },
                        success: function(response) {
                            if (response.notify && response.notify == 'success') {
                                modal_addnew.removeClass('opened');
                                setTimeout(function() {
                                    location.href = '//phuongtung.com/info/wp-admin/admin.php?page=tried-tcdm';
                                }, 1000);
                            } else {
                                modal_addnew.find('.notice .error').html(response.message);
                                modal_addnew.find('.notice').show();
                            }
                        },
                        complete: function() {
                            manage_tried.removeClass('proccessing');
                        },
                        error: function( jqXHR, textStatus, errorThrown ) {
                            console.log( 'The following error occured: ' + textStatus, errorThrown );
                        }
                    });
                }
            }
        });

        var names_manage_tcdm = ['title', 'description', 'value', 'option'];
        $(document).on('click', 'table.table-manage-tried-tcdm tr.inline-edit-row .save', function() {
            var table_data = [],
                wrapper = $(this).closest('tr'),
                func = $(this).attr('data-action'),
                itemid = $(this).attr('data-itemid');

            $(document).find(`.inline-edit-row.itemid-${itemid} .input-field`).each(function() {
                if ($(this).attr('role')) {
                    table_data[$(this).attr('role')] = $(this).val();
                    if ($(this).attr('type') == 'radio') {
                        table_data[$(this).attr('role')] = $(`.inline-edit-row.itemid-${itemid} .input-field[role="${$(this).attr('role')}"]:checked`).val();
                    }
                }
            });
                
            if (table_data) {
                let datafields = {
                    action: 'tried_update_tcdm',
                    role: func,
                    data: Object.assign({}, table_data)
                };

                if (func == 'update') datafields.id = itemid;

                $.ajax({
                    type: "POST", 
                    url: ajaxurl, 
                    data: datafields,
                    beforeSend: function() {
                        manage_tried.addClass('proccessing');
                        wrapper.find('.notice').hide();
                        wrapper.find('.notice .error').html('');
                    },
                    success: function(response) {
                        let row = $('table.table-manage-tried-tcdm tr.inline-row.itemid-'+itemid);
                        if (response.notify == 'success') {
                            if (response.result) {
                                if (response.result.status === '1') {
                                    row.find('.text-user').text('Đã').addClass('success');
                                    if (response.result.user_confirmed) row.find('.text-user').text(response.result.user_confirmed);
                                } else {
                                    row.find('.text-user').text('Chưa').removeClass('success');
                                }
                                location.href = "https://phuongtung.com/info/wp-admin/admin.php?page=tried-tcdm";
                            }
                            wrapper.removeClass('editting');
                            row.find('.delete').removeClass('disabled');
                        } else {
                            wrapper.find('.notice .error').html(response.message);
                            wrapper.find('.notice').show();
                        }
                    },
                    complete: function() {
                        manage_tried.removeClass('proccessing');
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                });
            }
        });

        $(document).on('click', 'table.table-manage-tried-tcdm tr.inline-row .delete', function() {
            var wrapper = $(this).closest('tr'),
                itemid = $(this).attr('data-itemid');

            if (itemid) {
                let datafields = {
                    action: 'tried_delete_tcdm',
                    id: itemid
                };

                $.ajax({
                    type: 'POST', 
                    url: ajaxurl, 
                    data: datafields,
                    beforeSend: function() {
                        manage_tried.addClass('proccessing');
                    },
                    success: function(response) {
                        let row_edit = $('table.table-manage-tried-tcdm tr.inline-edit-row.itemid-'+itemid);
                        if (response.notify == 'success') {
                            wrapper.remove();
                            row_edit.remove();
                        } else {
                            console.log( 'Có lỗi xảy ra!' );
                        }
                    },
                    complete: function() {
                        manage_tried.removeClass('proccessing');
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                });
            } else {
                console.log( 'Lỗi! thiếu thông tin `ID`' );
            }
        });

        function validate_input_fields(data) {
            var isval = true;
            data.forEach(function(item) {
                if(item[1] === '') isval = false;
            });
            return isval;
        }

        $(document).on('click', 'tr.inline-edit-row .submit .update', function() {
            var itemid = $(this).attr('data-itemid'),
                colspanchange = $(this).closest('.colspanchange'),
                data = [];

            names_manage_tcdm.forEach(function(name) {
                data.push([name, colspanchange.find('.input-'+name).val()]);
            });

            if (validate_input_fields(data)) {
                data.forEach(function(item) {
                    table_manage.find('tr.inline-row.itemid-'+itemid+' .text-'+item[0]).text(item[1]);
                    table_manage.find('tr.inline-row.itemid-'+itemid+' input[name="'+item[0]+'_'+itemid+'"]').val(item[1]);
                    if (item[0] === 'option') {
                        if (item[1] === '0') {
                            table_manage.find('tr.inline-row.itemid-'+itemid+' .text-'+item[0]).text('All products');
                        } else {
                            table_manage.find('tr.inline-row.itemid-'+itemid+' .text-'+item[0]).text('All products');
                        }
                    }
                });
                    
                table_manage.find('tr.inline-edit-row.itemid-'+itemid+' .notice p.error').text('Error: There are empty fields so it cannot be updated!');
                table_manage.find('tr.inline-edit-row.itemid-'+itemid+' .notice').addClass('hidden');
                table_manage.find('tr.inline-edit-row.itemid-'+itemid).toggleClass('editting');
            } else {
                table_manage.find('tr.inline-edit-row.itemid-'+itemid+' .notice p.error').text('Error: There are empty fields, so it cannot be updated!');
                table_manage.find('tr.inline-edit-row.itemid-'+itemid+' .notice').removeClass('hidden');
            }
        });

        modal_detail.find('.action .print').on('click', function() {
            var $this = $(this),
                itemid = $this.attr('data-id');

            if (itemid) {
                $.ajax({
                    type: "GET",
                    url: `tcdm-detail/${itemid}`,
                    beforeSend: function() {
                        manage_tried.addClass('proccessing');
                    },
                    success: function(res) {
                        if (res.result) {
                            if (typeof res.result.type != 'undefined' && res.result.type == 1) {
                                var parent = $this.closest('.html-print'),
                                    htmlPrint = parent.find('#printableArea').html(),
                                    mywindow = window.open('', 'my div', 'height=700,width=1200');

                                mywindow.document.write('<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Phiếu thu cũ đổi mới</title><link rel="stylesheet" href="http://19006660.com/js_css/font-awesome.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/ionicons.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/datatables/jquery.dataTables.min.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/daterangepicker/daterangepicker.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/datepicker/datepicker3.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/timepicker/bootstrap-timepicker.min.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/select2/select2.min.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/iCheck/square/blue.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/pace/pace.min.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/plugins/toast/jquery.toast.min.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/style.css?180320201548"> <link rel="stylesheet" href="http://19006660.com/js_css/skin-black.css?180320201548"> <link href="http://19006660.com/admin/modules/banhang/jsmod/styles.css?180320201548" rel="stylesheet" /> <link href="http://19006660.com/js_css/paper.css" rel="stylesheet" /><style>table{border-spacing:0;border-collapse:collapse}td,th{padding:0}.table{width:100%;max-width:100%;margin-bottom:20px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}.table-bordered{border:1px solid #ddd}.table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border:1px solid #ddd}.table-bordered>thead>tr>td,.table-bordered>thead>tr>th{border-bottom-width:2px}.table-striped>tbody>tr:nth-of-type(odd){background-color:#f9f9f9}.table-hover>tbody>tr:hover{background-color:#f5f5f5}table col[class*=col-]{position:static;display:table-column;float:none}table td[class*=col-],table th[class*=col-]{position:static;display:table-cell;float:none}.table>tbody>tr.active>td,.table>tbody>tr.active>th,.table>tbody>tr>td.active,.table>tbody>tr>th.active,.table>tfoot>tr.active>td,.table>tfoot>tr.active>th,.table>tfoot>tr>td.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>thead>tr.active>th,.table>thead>tr>td.active,.table>thead>tr>th.active{background-color:#f5f5f5}.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr.active:hover>th,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover{background-color:#e8e8e8}.table>tbody>tr.success>td,.table>tbody>tr.success>th,.table>tbody>tr>td.success,.table>tbody>tr>th.success,.table>tfoot>tr.success>td,.table>tfoot>tr.success>th,.table>tfoot>tr>td.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>thead>tr.success>th,.table>thead>tr>td.success,.table>thead>tr>th.success{background-color:#dff0d8}.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr.success:hover>th,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover{background-color:#d0e9c6}.table>tbody>tr.info>td,.table>tbody>tr.info>th,.table>tbody>tr>td.info,.table>tbody>tr>th.info,.table>tfoot>tr.info>td,.table>tfoot>tr.info>th,.table>tfoot>tr>td.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>thead>tr.info>th,.table>thead>tr>td.info,.table>thead>tr>th.info{background-color:#d9edf7}.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr.info:hover>th,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover{background-color:#c4e3f3}.table>tbody>tr.warning>td,.table>tbody>tr.warning>th,.table>tbody>tr>td.warning,.table>tbody>tr>th.warning,.table>tfoot>tr.warning>td,.table>tfoot>tr.warning>th,.table>tfoot>tr>td.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>thead>tr.warning>th,.table>thead>tr>td.warning,.table>thead>tr>th.warning{background-color:#fcf8e3}.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr.warning:hover>th,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover{background-color:#faf2cc}.table>tbody>tr.danger>td,.table>tbody>tr.danger>th,.table>tbody>tr>td.danger,.table>tbody>tr>th.danger,.table>tfoot>tr.danger>td,.table>tfoot>tr.danger>th,.table>tfoot>tr>td.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>thead>tr.danger>th,.table>thead>tr>td.danger,.table>thead>tr>th.danger{background-color:#f2dede}.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr.danger:hover>th,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover{background-color:#ebcccc}.table-responsive{min-height:.01%;overflow-x:auto}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>td,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>thead>tr>th{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>thead>tr>th:first-child{border-left:0}.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>thead>tr>th:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>th{border-bottom:0}}</style>');

                                mywindow.document.write('<style>.sheet.padding-5mm { padding: 5mm 10mm }body{max-width:800px;margin:0px auto;font-size:10.5px;line-height:16px;-webkit-print-color-adjust:exact;}.noprint{display:none!important;}.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{padding:2px 8px;}.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{border: 1px solid #000 !important;}#printableArea .table-bordered{border:1px solid #000;}.rowblue{background:#ccdeff !important;}</style>');
                                mywindow.document.write('</head><body class="A5 landscape">');  
                                mywindow.document.write('<section class="sheet padding-5mm">');
                                mywindow.document.write(htmlPrint);
                                mywindow.document.write('</section>');
                                mywindow.document.write('</body></html>');
                                mywindow.print();
                            } else {
                                console.log( 'Thông tin chưa được xác nhận!' );
                            }
                        } else {
                            console.log( 'Có lỗi xảy ra!' );
                        }
                    },
                    complete: function() {
                        manage_tried.removeClass('proccessing');
                    },
                    error: function( jqXHR, textStatus, errorThrown ) {
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                });
            }
        });
    }
});
