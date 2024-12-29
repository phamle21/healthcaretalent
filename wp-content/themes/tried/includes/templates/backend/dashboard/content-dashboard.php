<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shops = array();
if ( isset( $_POST['action'] ) && $_POST['action'] == 'insert-shop' ) {
    if ( isset( $_POST['title'] ) && !empty( $_POST['title'] ) ) {
        $dbShop->insert( array(
            'title' => $_POST['title'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'manager' => $_POST['manager'],
            'business' => $_POST['business']
        ) );
    }
}
if ( isset( $_POST['action'] ) && $_POST['action'] == 'update-shop' ) {
    if ( isset( $_POST['id'] ) && !empty( $_POST['id'] ) ) {
        $dbShop->update( $_POST['id'], array(
            'title' => $_POST['title'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'manager' => $_POST['manager'],
            'business' => $_POST['business'],
            'status' => isset($_POST['status'])?$_POST['status']:0
        ) );
    }
}
?>
<div id="prodattribute">
    <div class="head-prodattribute">
        <h2><?php _e( 'Thiết lập', 'tried' ); ?></h2>
        <div class="act-prodattribute">
            <a href="javascript:void(0)" class="toggle-modal" data-target="#modalShop"
                title="<?php _e( 'Cửa hàng mới', 'tried' ); ?>"><?php _e( 'Cửa hàng mới', 'tried' ); ?></a>
        </div>
    </div>
    <div class="body-prodattribute">
        <div class="navtitle-category">
            <ul>
                <li class="active"><a href="javascript:void(0)" data-target="#category-shop"
                        title="<?php _e( 'Cửa hàng', 'tried' ); ?>"><?php _e( 'Cửa hàng', 'tried' ); ?></a></li>
            </ul>
        </div>

        <div class="navcontent-category">
            <div id="category-shop" class="active">
                <div class="shops">
                    <?php
                        if ( !empty( $shops ) ) {
                            printf(
                                '<div class="shop-item head">
                                    <div class="text-field">%s</div>
                                    <div class="text-field">%s</div>
                                    <div class="text-field">%s</div>
                                    <div class="text-field">%s</div>
                                    <div class="text-field">%s</div>
                                    <div class="text-field">%s</div>
                                    <div class="text-field">%s</div>
                                    <div class="text-field"></div>
                                </div>',
                                __( 'STT', 'tried' ), __( 'Cửa hàng', 'tried' ), __( 'Địa chỉ', 'tried' ), __( 'Số điện thoại', 'tried' ), __( 'Quản lý', 'tried' ), __( 'Kinh doanh', 'tried' ), __( 'Hoạt động', 'tried' )
                            );
                            foreach ( $shops as $c => $shop ) {
                                printf(
                                    '<div class="shop-item" data-id="%s">
                                        <div class="text-field" role="stt">%s</div>
                                        <div class="text-field" role="title">%s</div>
                                        <div class="text-field" role="address">%s</div>
                                        <div class="text-field" role="phone">%s</div>
                                        <div class="text-field" role="manager">%s</div>
                                        <div class="text-field" role="business" data-business="%s">%s</div>
                                        <div class="text-field" role="status" data-status="%s"><span class="%s"></span></div>
                                        <div class="text-field action">
                                            <a href="javascript:void(0)" class="toggle-modal update" data-target="#modalShop" title="%s">
                                                <svg fill="#000000" height="14px" width="14px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 306.637 306.637" xml:space="preserve">
                                                    <path d="M12.809,238.52L0,306.637l68.118-12.809l184.277-184.277l-55.309-55.309L12.809,238.52z M60.79,279.943l-41.992,7.896 l7.896-41.992L197.086,75.455l34.096,34.096L60.79,279.943z"/>
                                                    <path d="M251.329,0l-41.507,41.507l55.308,55.308l41.507-41.507L251.329,0z M231.035,41.507l20.294-20.294l34.095,34.095 L265.13,75.602L231.035,41.507z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>',
                                    $shop->id, $c+1, $shop->title, $shop->address, $shop->phone, $shop->manager,
                                    $shop->business, $shop->business!=0?__( 'Có', 'tried' ):__( 'Không', 'tried' ),
                                    $shop->status, $shop->status!=0?'active':'non-active', __( 'Chỉnh sửa', 'tried' )
                                );
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div id="modalShop" class="modal-dashboard">
        <div class="modal-overlay"></div>
        <div class="modal-wrapper">
            <div class="modal-header">
                <h4 class="modal-title"><?php _e( 'Modal Cửa hàng', 'tried' ); ?></h4>
                <a href="javascript:void(0)" class="toggle-modal" data-target="#modalShop">
                    <svg width="18px" height="18px" viewBox="0 0 19 19" role="presentation">
                        <path
                            d="M9.1923882 8.39339828l7.7781745-7.7781746 1.4142136 1.41421357-7.7781746 7.77817459 7.7781746 7.77817456L16.9705627 19l-7.7781745-7.7781746L1.41421356 19 0 17.5857864l7.7781746-7.77817456L0 2.02943725 1.41421356.61522369 9.1923882 8.39339828z"
                            fill-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <div class="modal-body">
                <form action="<?php echo admin_url( 'admin.php?page=tried-dashboard' ); ?>" method="post">
                    <input type="hidden" name="action" value="insert-shop">
                    <input type="hidden" name="id" value="">
                    <div class="field-inline">
                        <label for="modal-title"><?php _e( 'Tên cửa hàng', 'tried' ); ?></label>
                        <input type="text" name="title" id="modal-title"
                            placeholder="<?php _e( 'Nhập tên cửa hàng', 'tried' ); ?>">
                    </div>
                    <div class="field-inline">
                        <label for="modal-address"><?php _e( 'Địa chỉ', 'tried' ); ?></label>
                        <textarea name="address" id="modal-address"
                            placeholder="<?php _e( 'Nhập địa chỉ', 'tried' ); ?>"></textarea>
                    </div>
                    <div class="field-inline">
                        <label for="modal-phone"><?php _e( 'Số điện thoại', 'tried' ); ?></label>
                        <input type="text" name="phone" id="modal-phone"
                            placeholder="<?php _e( 'Nhập số điện thoại', 'tried' ); ?>">
                    </div>
                    <div class="field-inline business" style="display: none;">
                        <label for="modal-business"><input type="checkbox" name="business" id="modal-business"
                                value="1"> <?php _e( 'Bán hàng', 'tried' ); ?></label>
                    </div>
                    <div class="field-inline">
                        <label for="modal-manager"><?php _e( 'Quản lý', 'tried' ); ?></label>
                        <input type="text" name="manager" id="modal-manager"
                            placeholder="<?php _e( 'Nhập tên quản lý', 'tried' ); ?>">
                    </div>
                    <div class="field-inline status" style="display: none;">
                        <label for="modal-status"><input type="checkbox" name="status" id="modal-status" value="1">
                            <?php _e( 'Hoạt động', 'tried' ); ?></label>
                    </div>
                    <div class="field-inline">
                        <button type="submit"><?php _e( 'Thêm mới', 'tried' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
(function($) {
    'use strict';

    $(document).on('click', '.navtitle-category a', function() {
        $('.navtitle-category li.active').removeClass('active');
        $(this).parent().addClass('active');
        $('.navcontent-category > div.active').removeClass('active');
        $('.navcontent-category > div' + $(this).attr('data-target')).addClass('active');
    });

    $(document).on('click', '.toggle-modal', function() {
        var modal = $('.modal-dashboard' + $(this).attr('data-target'));
        if ($(this).attr('data-target')) {
            modal.toggleClass('opened');
        }
        if (!$(this).hasClass('update')) {
            modal.find('form')[0].reset();
            modal.find('form [name="action"]').val('insert-shop');
            modal.find('form [name="id"]').val('');
            modal.find('.field-inline.status').hide();
            modal.find('.field-inline.business').hide();
            modal.find('.field-inline button[type="submit"]').text('<?php _e( 'Thêm mới', 'tried' ); ?>');
        } else {
            var wrapper = $(this).closest('.shop-item'),
                id = wrapper.attr('data-id'),
                title = wrapper.find('.text-field[role="title"]').text(),
                address = wrapper.find('.text-field[role="address"]').text(),
                phone = wrapper.find('.text-field[role="phone"]').text(),
                manager = wrapper.find('.text-field[role="manager"]').text(),
                business = wrapper.find('.text-field[role="business"]').attr('data-business'),
                status = wrapper.find('.text-field[role="status"]').attr('data-status');

            modal.find('form [name="action"]').val('update-shop');
            modal.find('form [name="id"]').val(id);
            modal.find('.field-inline.status').show();
            modal.find('.field-inline.business').show();

            modal.find('.field-inline [name="title"]').val(title);
            modal.find('.field-inline [name="address"]').val(address);
            modal.find('.field-inline [name="phone"]').val(phone);
            modal.find('.field-inline [name="manager"]').val(manager);
            if (status == '1') {
                modal.find('.field-inline [name="status"]').prop('checked', true);
            } else {
                modal.find('.field-inline [name="status"]').prop('checked', false);
            }
            if (business == '1') {
                modal.find('.field-inline [name="business"]').prop('checked', true);
            } else {
                modal.find('.field-inline [name="business"]').prop('checked', false);
            }
            modal.find('.field-inline button[type="submit"]').text('<?php _e( 'Cập nhật', 'tried' ); ?>');
        }
    });
})(jQuery);
</script>

<style>
.shops .shop-item {
    display: grid;
    grid-template-columns: 40px 200px auto 120px 150px 100px 50px 70px;
    align-items: center;
}

.shops .shop-item.head {
    background-color: #11b011;
    color: #fff;
}

.shops .shop-item.head .text-field {
    padding: 7px 10px;
}

.shops .shop-item:not(:last-child) {
    margin-bottom: 10px;
}

.shops .shop-item .text-field {
    padding: 2px 8px;
}

.shops .shop-item .text-field:not(:last-child) {
    border-right: 1px solid #ccc;
}

.shops .shop-item .text-field:nth-child(1),
.shops .shop-item .text-field:nth-child(4),
.shops .shop-item .text-field:nth-child(5),
.shops .shop-item .text-field:nth-child(6),
.shops .shop-item .text-field:nth-child(7),
.shops .shop-item .text-field:nth-child(8) {
    text-align: center;
}

.shops .shop-item .text-field[role="status"] span {
    background-color: white;
    color: #fff;
    border-radius: 50%;
    font-size: 0;
    width: 12px;
    height: 12px;
    display: block;
    margin: 0 auto;
    border: 2px solid #ccc;
}

.shops .shop-item .text-field span.active {
    background-color: green;
}

.shops .shop-item .text-field span.non-active {
    background-color: red;
}

#prodattribute {
    background-color: #050505;
    border-radius: 2px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
}

.modal-dashboard {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 99999999;
    opacity: 0;
    visibility: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .3s;
}

.modal-dashboard.opened {
    opacity: 1;
    visibility: visible;
}

.modal-dashboard .modal-overlay {
    background-color: rgba(0, 0, 0, .3);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.modal-dashboard .modal-wrapper {
    background-color: #fff;
    width: 100%;
    max-width: 450px;
    border-radius: 5px;
    transform: translateY(100px);
    transition: opacity .2s, transform .5s;
}

.modal-dashboard.opened .modal-wrapper {
    transform: translateY(0);
}

.modal-dashboard .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 15px;
    border-bottom: 1px solid #f1f1f1;
}

.modal-dashboard .modal-body {
    padding: 20px 15px;
}

.modal-dashboard .modal-body form .field-inline:not(:last-child) {
    margin-bottom: 15px;
}

.modal-dashboard .modal-body form .field-inline label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    line-height: 20px;
    margin-bottom: 7px;
}

.modal-dashboard .modal-body form .field-inline input[type="text"],
.modal-dashboard .modal-body form .field-inline textarea {
    width: 100%;
    font-size: 12px;
    font-weight: 400;
    line-height: 40px;
    height: 40px;
}

.modal-dashboard .modal-body form .field-inline textarea {
    height: 64px;
    line-height: 20px;
}

.modal-dashboard .modal-body form .field-inline button[type="submit"] {
    width: 100%;
    font-size: 14px;
    font-weight: 400;
    line-height: 30px;
    text-transform: uppercase;
    height: 40px;
    background-color: #13a213;
    color: #fff;
    outline: none;
    border: none;
    cursor: pointer;
}

.modal-dashboard .modal-title {
    margin: 0;
    font-size: 18px;
    font-weight: 500;
    line-height: 24px;
}

.head-prodattribute {
    padding: 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.head-prodattribute h2 {
    color: #fff;
    font-size: 15px;
    font-weight: 500;
    line-height: 24px;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0;
}

.head-prodattribute .act-prodattribute a {
    color: #fff;
    background-color: #13a213;
    font-size: 13px;
    font-weight: 500;
    line-height: 24px;
    text-transform: uppercase;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 3px;
}

.body-prodattribute {
    display: grid;
    grid-template-columns: 220px auto;
}

.navtitle-category ul {
    margin: 0;
}

.navtitle-category ul li {
    margin-bottom: 0;
}

.navtitle-category ul li:not(:last-child) {
    border-bottom: 1px solid #f1f1f1;
}

.navtitle-category ul a {
    display: block;
    padding: 15px;
    font-size: 14px;
    font-weight: 400;
    line-height: 20px;
    text-decoration: none;
    color: #999;
    background-color: #333;
    border-bottom: 1px solid #2f2f2f;
}

.navtitle-category ul li.active a,
.navtitle-category ul li a:hover {
    color: #fff;
    background-color: #111;
}

.navcontent-category {
    position: relative;
}

.navcontent-category>div {
    display: none;
    background-color: #fff;
    padding: 30px;
    height: calc(100% - 60px);
}

.navcontent-category>div.active {
    display: block;
}
</style>