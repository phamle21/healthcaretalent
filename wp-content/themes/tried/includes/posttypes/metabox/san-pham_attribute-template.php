<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style( 'tried-metabox-attribute_san-pham' );

global $post;
$k_prodattr_category = 'prodattr_category';
$prodattr_category = get_post_meta( $post->ID, $k_prodattr_category, true );

$dbProdAttributeCategory = new Tried_DB__ProdAttributeCategory();
$dbProdAttributeCluster = new Tried_DB__ProdAttributeCluster();

$prodattr_categories = array_reverse( $dbProdAttributeCategory->all() );

$prodattr_clusters = array();
if ( $prodattr_category && !empty( $prodattr_category ) ) {
  $prodattr_clusters = $dbProdAttributeCluster->get_by_category_id( $prodattr_category );
}

$k_prodattr_cluster = 'prodattr_cluster';
$prodattr_cluster = get_post_meta( $post->ID, $k_prodattr_cluster, true );
?>
<fieldset class="metabox-block">
    <article class="metabox-article">
        <div class="metabox-option handle-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Ngành hàng', 'tried' ); ?>:</h4>
            <div class="option-wrapper">
                <div class="option-inpt">
                    <select name="<?php echo $k_prodattr_category; ?>">
                        <option value=""><?php _e( 'Chọn ngành hàng', 'tried' ); ?></option>
                        <?php
              if ( !empty( $prodattr_categories ) ) {
                foreach ( $prodattr_categories as $cat ) {
                  printf( '<option value="%s" %s>%s</option>', $cat->id, ($cat->id == $prodattr_category)?'selected':'', $cat->title );
                }
              }
            ?>
                    </select>
                </div>
            </div>
        </div>
    </article>
    <article class="metabox-article">
        <div class="metabox-option handle-<?php echo $post->ID; ?>-posttype">
            <h4 class="option-title"><?php _e( 'Thông số kỹ thuật', 'tried' ); ?></h4>
            <div class="option-wrapper">
                <div class="option-block">
                    <table id="tableProdAttribute" class="empty">
                        <thead>
                            <tr>
                                <th><?php _e( 'STT', 'tried' ); ?></th>
                                <th><?php _e( 'Biến thể', 'tried' ); ?></th>
                                <th><?php _e( 'Nhóm', 'tried' ); ?></th>
                                <th><?php _e( 'Thuộc tính', 'tried' ); ?></th>
                                <th><?php _e( 'Giá trị', 'tried' ); ?></th>
                                <th>
                                    <a href="javascript:void(0)" class="row-addnew"
                                        title="<?php _e( 'Thêm thuộc tính', 'tried' ); ?>">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M12.5416 22.2446C18.0645 22.2446 22.5416 17.7675 22.5416 12.2446C22.5416 6.72178 18.0645 2.24463 12.5416 2.24463C7.01878 2.24463 2.54163 6.72178 2.54163 12.2446C2.54163 17.7675 7.01878 22.2446 12.5416 22.2446Z"
                                                fill="green" stroke="green" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path d="M12.5416 8.24463V16.2446" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M8.54163 12.2446H16.5416" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="none-result">
                                <td colspan="6">
                                    <?php _e( 'Sorry, no results were returned', 'tried' ); ?>
                                    <input type="hidden" name="prodattr_cluster" value="" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </article>
</fieldset>

<script>
(function($) {
    'use strict';

    var tableProdAttribute = $('#tableProdAttribute');
    if (tableProdAttribute.length > 0) {
        $(document).on('click', '.row-remove', function() {
            $(this).closest('tr').remove();
            if (tableProdAttribute.find('tbody tr').length <= 1) {
                tableProdAttribute.addClass('empty');
            }
        });

        var CLUSTER = [],
            __CLUSTERS = [];

        <?php 
        if ( !empty( $prodattr_clusters ) ) {
          foreach ( $prodattr_clusters as $cluster ) {
            printf('jsonCluster(%s);', json_encode($cluster) );
          }
        }
      ?>

        function jsonCluster(json = false) {
            if (!json) return;
            var general_id = false,
                title = false,
                parameter = false;

            $.each(json, function(key, value) {
                if (key === 'general_id') general_id = value;
                if (key === 'title') title = value;
                if (key === 'parameter') parameter = JSON.parse(value);
            });
            __CLUSTERS.push({
                'cluster_id': general_id,
                'title': title,
                'parameter': parameter
            });
        }

        <?php if ( isset( $prodattr_cluster ) && !empty( $prodattr_cluster ) ) printf( 'CLUSTER = %s;', json_encode( $prodattr_cluster ) ); ?>

        function renderHTMLCluster(clusters = []) {
            if (clusters.length <= 0) {
                tableProdAttribute.addClass('empty');
            } else {
                Object.keys(clusters).forEach(function(key, index) {
                    createCluster(this[key]);
                }, clusters);
            }
        }
        renderHTMLCluster(CLUSTER);

        function createCluster(args = false) {
            var htmlCluster = '',
                currentCluster = false,
                indexCluster = tableProdAttribute.find('tbody tr:not(.none-result)').length;

            if (__CLUSTERS.length > 0) {
                __CLUSTERS.forEach(cl => {
                    let slctSelected = '';
                    if (typeof args['cluster'] != 'undefined' && cl['title'] === args['cluster']) {
                        currentCluster = cl;
                        slctSelected = 'selected';
                    }
                    htmlCluster +=
                        `<option value="${cl['title']}" data-cluster_id="${cl['cluster_id']}" ${slctSelected}>${cl['title']}</option>`;
                });
            }

            var newCluster = $(
                `<tr>
            <td></td>
            <td><select name="prodattr_cluster[${indexCluster}][variant]" class="slct-variant select2 dynamic"><option value=""><?php _e( 'Chọn biến thể', 'tried' ); ?></option></select></td>
            <td><select name="prodattr_cluster[${indexCluster}][cluster]" class="slct-cluster"><option value=""><?php _e( 'Chọn nhóm thuộc tính', 'tried' ); ?></option>${htmlCluster}</select></td>
            <td><select name="prodattr_cluster[${indexCluster}][parameter]" class="slct-parameter select2"></select></td>
            <td><select name="prodattr_cluster[${indexCluster}][value][]" class="slct-value select2 dynamic" multiple="multiple"></select></td>
            <td>
              <a href="javascript:void(0)" class="row-remove" title="<?php _e( 'Xoá thuộc tính', 'tried' ); ?>">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="red" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.6575 22.4961C18.1803 22.4961 22.6575 18.0189 22.6575 12.4961C22.6575 6.97325 18.1803 2.49609 12.6575 2.49609C7.13462 2.49609 2.65747 6.97325 2.65747 12.4961C2.65747 18.0189 7.13462 22.4961 12.6575 22.4961Z" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M15.6575 9.49609L9.65747 15.4961" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M9.65747 9.49609L15.6575 15.4961" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </a>
            </td>
          </tr>`
            );

            tableProdAttribute.find('tbody').append(newCluster);
            initializeSelect2(newCluster.find('.select2'));
            if (tableProdAttribute.hasClass('empty')) {
                tableProdAttribute.removeClass('empty');
            }
            if (__CLUSTERS.length > 0) {
                setTimeout(() => {
                    newCluster.find('.slct-cluster').change();
                    newCluster.find('.slct-parameter').trigger('change', [args]);
                }, 100);
            }

            loadVariant(newCluster, args['variant']);
            initializeSelect2(newCluster.find('.slct-variant'), true);
        }

        function loadVariant(cluster, variant = false) {
            var slct_variant = cluster.find('.slct-variant');
            setTimeout(() => {
                $('fieldset.prod-variants .navtab-item').each(function() {
                    let slctSelected = '';
                    if (variant && $(this).attr('data-target') === variant) slctSelected =
                        'selected';
                    slct_variant.append(
                        `<option value="${$(this).attr('data-target')}" ${slctSelected}>${$(this).attr('data-target')}</option>`
                    );
                });

                if (variant && !slct_variant.find(`option[value="${variant}"]`).length > 0) {
                    slct_variant.append(`<option value="${variant}" selected>${variant}</option>`);
                }
            }, 100);
        }

        $(document).on('change', '.slct-cluster', function() {
            var tr = $(this).closest('tr'),
                cluster_id = $('option:selected', this).attr('data-cluster_id');

            tr.find('.slct-parameter').html(
                '<option value="" selected><?php _e( 'Chọn thuộc tính', 'tried' ); ?></option>');
            if (cluster_id && cluster_id != '') {
                let cluster = __CLUSTERS.find(p => p.cluster_id === cluster_id);

                if (typeof cluster['parameter'] != 'undefined' && !_.isEmpty(cluster['parameter'])) {
                    for (const [key, value] of Object.entries(cluster['parameter'])) {
                        tr.find('.slct-parameter').append(
                            `<option value="${value['name']}" data-cluster_id="${cluster_id}" >${value['name']}</option>`
                        );
                    }
                }
            }
            initializeSelect2(tr.find('.slct-parameter'));
        });

        $(document).on('change', '.slct-parameter', function(event, json) {
            var tr = $(this).closest('tr'),
                cluster_id = $('option:selected', this).attr('data-cluster_id'),
                jsonCluster = false;

            if (typeof json != 'undefined') jsonCluster = json;

            tr.find('.slct-value').html('');
            if (cluster_id && cluster_id != '') {
                let cluster = __CLUSTERS.find(p => p.cluster_id === cluster_id),
                    parameter = [cluster['parameter']].flatMap(x => x).find(c => c['name'] === $(this)
                        .val());

                if (typeof parameter != 'undefined' && (typeof parameter['value'] != 'undefined' && !_
                        .isEmpty(parameter['value']))) {
                    parameter['value'].forEach(pr => {
                        tr.find('.slct-value').append(`<option value="${pr}">${pr}</option>`);
                    });
                } else {
                    if (typeof cluster['parameter'] != 'undefined' && !_.isEmpty(cluster['parameter'])) {
                        for (const [key, value] of Object.entries(cluster['parameter'])) {
                            if (typeof value['value'] != 'undefined' && value['name'] === $(this).val()) {
                                value['value'].forEach(pr => {
                                    tr.find('.slct-value').append(
                                        `<option value="${pr}">${pr}</option>`);
                                });
                            }
                        }
                    }
                }
            }
            initializeSelect2(tr.find('.slct-value'), true);
            if (typeof jsonCluster['parameter'] != 'undefined') {
                tr.find(`.slct-parameter option[value="${jsonCluster['parameter']}"]`).prop('selected',
                    true).change();
            }
            if (typeof jsonCluster['value'] != 'undefined' && jsonCluster['value'].length > 0) {
                jsonCluster['value'].forEach(v => {
                    if (tr.find(`.slct-value option[value="${v}"]`).length > 0) {
                        tr.find(`.slct-value option[value="${v}"]`).prop('selected', true);
                    } else {
                        tr.find('.slct-value').append(
                            `<option value="${v}" selected>${v}</option>`);
                    }
                });
            }
            tr.find('.slct-value').change();
        });

        $(document).on('click', '.row-addnew', function() {
            createCluster();
        });
    }

    initializeSelect2($('.select2'));

    function initializeSelect2(slct, dynamic = false) {
        var selectValue = [],
            args = {
                width: 'style',
                allowClear: true,
                placeholder: "<?php _e( 'Chọn giá trị', 'tried' ); ?>"
            };
        if (dynamic) {
            args.tags = true;
        }
        slct.select2(args);
        slct.find('option').each(function() {
            if ($(this).val() != '') selectValue.push($(this).val());
        });
        slct.val(selectValue).val('').trigger('change');
    }
})(jQuery);
</script>