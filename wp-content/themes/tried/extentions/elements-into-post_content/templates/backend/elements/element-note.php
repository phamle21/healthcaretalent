<?php
// Template: Component Noteimportant

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="element-wrap" data-element="heading">
  <div class="meta-list">
    <div class="meta-option">
      <h5 class="title-option"><?php _e( 'Loại chú thích', 'tried' ); ?></h5>
      <div class="wapper-option">
        <select name="kind">
          <option value="attention" selected><?php _e( 'Ghi chú', 'tried' ); ?></option>
          <option value="important"><?php _e( 'Quan trọng', 'tried' ); ?></option>
          <option value="warning"><?php _e( 'Cảnh bảo', 'tried' ); ?></option>
        </select>
      </div>
    </div>
    <div class="meta-option">
      <h5 class="title-option"><?php _e( 'Content', 'tried' ); ?></h5>
      <div class="wapper-option">
        <textarea class="trumbowyg-edior" name="content"></textarea>
      </div>
    </div>
  </div>
</div>
