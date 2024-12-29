<?php
// Template: Component Heading

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="element-wrap" data-element="heading">
  <div class="meta-list">
    <div class="meta-option">
      <h5 class="title-option"><?php _e( 'Title', 'tried' ); ?></h5>
      <div class="wapper-option heading-preview" data-tag="h3">
        <input type="text" name="heading" placeholder="<?php _e( 'Nhập tiêu đề', 'tried' ); ?>">
      </div>
    </div>
    <div class="meta-option">
      <h5 class="title-option"><?php _e( 'Phân cấp tiêu đề', 'tried' ); ?></h5>
      <div class="wapper-option">
        <select name="level">
          <option value="h3" selected><?php _e( 'Title', 'tried' ); ?>1 - h3</option>
          <option value="h4">&nbsp;<?php _e( 'Title', 'tried' ); ?>2 - h4</option>
          <option value="h5">&nbsp;&nbsp;<?php _e( 'Title', 'tried' ); ?>3 - h5</option>
          <option value="h6">&nbsp;&nbsp;&nbsp;<?php _e( 'Title', 'tried' ); ?>4 - h6</option>
        </select>
      </div>
    </div>
  </div>
</div>
