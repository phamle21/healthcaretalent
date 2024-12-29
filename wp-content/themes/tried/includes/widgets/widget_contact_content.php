<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class widget_contact_content extends WP_Widget {
    function __construct() {
		parent::__construct(
			'widget_contact_content', 'Tried Contact Content',
			array(
				'classname' => 'widget_contact_content',
				'description' => '',
				'customize_selective_refresh' => true
			)
		);
	}

    function widget($args, $instance) {
	    $defaults = array(
			'title_question' => '', 'content_question' => '', 'phone_question' => '', 'email_question' => '',
			'title_address' => '', 'content_address' => '',
			'title_support' => '', 'content_support' => '',
			'title_contact' => '', 'content_contact' => '',
		);
        $instance = wp_parse_args($instance, $defaults);
		$title_question = ($instance['title_question']);
		$content_question = ($instance['content_question']);
		$phone_question = ($instance['phone_question']);
		$email_question = ($instance['email_question']);

		$title_address = ($instance['title_address']);
		$content_address = ($instance['content_address']);

		$title_support = ($instance['title_support']);
		$content_support = ($instance['content_support']);

		$title_contact = ($instance['title_contact']);
		$content_contact = ($instance['content_contact']);
		echo $args['before_widget'];
		?>
			<section id="widget-<?php echo $args['widget_id']; ?>" class="section-contact-content">
				<div class="section-wrapper margin-auto">
					<div class="question-block box-block">
						<div class="wrapper">
							<div class="image-left">
								<img src="<?php echo get_theme_file_uri( "/assets/img/contact-content.jpg" ); ?>" alt="">
							</div>
							<div class="info-right">
								<h4 class="title"><?php echo $title_question; ?></h4>
								<div class="content"><?php echo $content_question; ?></div>
								<ul class="infos">
									<?php if (!empty($phone_question)) : ?>
										<li><a href="<?php echo $phone_question; ?>"><i class="fas fa-phone-alt"></i><?php echo $phone_question; ?></a></li>
									<?php endif; ?>
									<?php if (!empty($email_question)) : ?>
										<li><a href="<?php echo $email_question; ?>"><i class="fal fa-envelope"></i><?php echo $email_question; ?></a></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="subwrap">
						<div class="address-block box-block">
							<div class="wrapper">
								<h4 class="title"><?php echo $title_address; ?></h4>
								<div class="content"><?php echo $content_address; ?></div>
							</div>
						</div>
						<div class="support-block box-block">
							<div class="wrapper">
								<h4 class="title"><?php echo $title_support; ?></h4>
								<div class="content"><?php echo $content_support; ?></div>
							</div>
						</div>
						<div class="contact-block box-block">
							<div class="wrapper">
								<h4 class="title"><?php echo $title_contact; ?></h4>
								<div class="content"><?php echo $content_contact; ?></div>
							</div>
						</div>
					</div>
			    </div>
			</section>
        <?php
		echo $args['after_widget'];
    }
	
    function update($new_instance, $old_instance) {
        $instance = array();
		$instance['title_question'] = ($new_instance['title_question']);
		$instance['content_question'] = ($new_instance['content_question']);
		$instance['phone_question'] = ($new_instance['phone_question']);
		$instance['email_question'] = ($new_instance['email_question']);

		$instance['title_address'] = ($new_instance['title_address']);
		$instance['content_address'] = ($new_instance['content_address']);

		$instance['title_support'] = ($new_instance['title_support']);
		$instance['content_support'] = ($new_instance['content_support']);

		$instance['title_contact'] = ($new_instance['title_contact']);
		$instance['content_contact'] = ($new_instance['content_contact']);
        return $instance;
    }

    function form($instance) {
	    $defaults = array(
			'title_question' => '', 'content_question' => '', 'phone_question' => '', 'email_question' => '',
			'title_address' => '', 'content_address' => '',
			'title_support' => '', 'content_support' => '',
			'title_contact' => '', 'content_contact' => '',
		);
        $instance = wp_parse_args($instance, $defaults);
		?>
			<h5><?php esc_html_e('Nhóm câu hỏi chính', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_question')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_question']); ?>" name="<?php echo esc_attr($this->get_field_name('title_question')); ?>" id="<?php echo esc_attr($this->get_field_id('title_question')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content_question')); ?>"><?php esc_html_e('Content', ''); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_question')); ?>" id="<?php echo esc_attr($this->get_field_id('content_question')); ?>" cols="30" rows="4"><?php echo esc_attr($instance['content_question']); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('phone_question')); ?>"><?php esc_html_e('Số điện thoại', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['phone_question']); ?>" name="<?php echo esc_attr($this->get_field_name('phone_question')); ?>" id="<?php echo esc_attr($this->get_field_id('phone_question')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('email_question')); ?>"><?php esc_html_e('Email', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['email_question']); ?>" name="<?php echo esc_attr($this->get_field_name('email_question')); ?>" id="<?php echo esc_attr($this->get_field_id('email_question')); ?>" />
			</p>
			<h5><?php esc_html_e('Nhóm địa chỉ', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_address')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_address']); ?>" name="<?php echo esc_attr($this->get_field_name('title_address')); ?>" id="<?php echo esc_attr($this->get_field_id('title_address')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content_address')); ?>"><?php esc_html_e('Content', ''); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_address')); ?>" id="<?php echo esc_attr($this->get_field_id('content_address')); ?>" cols="30" rows="4"><?php echo esc_attr($instance['content_address']); ?></textarea>
			</p>
			<h5><?php esc_html_e('Nhóm hỗ trợ', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_support')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_support']); ?>" name="<?php echo esc_attr($this->get_field_name('title_support')); ?>" id="<?php echo esc_attr($this->get_field_id('title_support')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content_support')); ?>"><?php esc_html_e('Content', ''); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_support')); ?>" id="<?php echo esc_attr($this->get_field_id('content_support')); ?>" cols="30" rows="4"><?php echo esc_attr($instance['content_support']); ?></textarea>
			</p>
			<h5><?php esc_html_e('Nhóm liên hệ', ''); ?></h5>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title_contact')); ?>"><?php esc_html_e('Title', ''); ?></label>
				<input class="widefat" type="text" value="<?php echo esc_attr($instance['title_contact']); ?>" name="<?php echo esc_attr($this->get_field_name('title_contact')); ?>" id="<?php echo esc_attr($this->get_field_id('title_contact')); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('content_contact')); ?>"><?php esc_html_e('Content', ''); ?></label>
				<textarea class="widefat" name="<?php echo esc_attr($this->get_field_name('content_contact')); ?>" id="<?php echo esc_attr($this->get_field_id('content_contact')); ?>" cols="30" rows="4"><?php echo esc_attr($instance['content_contact']); ?></textarea>
			</p>
   		<?php
    }
}
