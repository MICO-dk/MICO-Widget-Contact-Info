<?php
/**
 * 
 */
namespace mico\widget;

class contact_info extends \WP_Widget {

	function __construct() {
		
		// Instantiate the parent object
		// Note that the base id MUST not be false, when using namespace.
		parent::__construct( 'contact_info', __('Contact Info', 'mico-contact-widget'), array( 'description' => __('Display contact information', 'mico-contact-widget'), ) );
	
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	function widget( $args, $instance ) {
		
		$image_id = $instance['image_id'];
		$image_size = 'medium';
		

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			
			// display image
			if(!empty($image_id)) {
				$image = wp_get_attachment_image_src( $image_id, 'medium' );
				$image_html = '<img src="' . $image[0] . '" alt="" style="max-width:100%; display:block;">';
				$image_output = apply_filters( 'mico_widget_contact_info_image_html', $image_html, $image_id );		
				echo $image_output;
			}

			// display content in wrapper
			echo '<div class="widget_contact_info_content">';
				
				// displat title
				echo $args['before_title'];
				echo apply_filters( 'widget_title', $instance['title'] );
				echo $args['after_title'];

				

				echo '<ul class="mico-widget-contact-info-details">';
				
				// display name
				if ( !empty( $instance['name'] ) ) {
					echo '<li class="mico-widget-contact-info-name">' . $instance['name'] . '</li>';
				}
				
				// display phone
				if ( !empty( $instance['phone'] ) ) {
					echo '<li><a href="tel:'. str_replace(' ', '', $instance['phone']) .'" class="mico-widget-contact-info-phone">' . $instance['phone'] . '</a></li>';
				}

				// display email
				if ( !empty( $instance['email'] ) ) {
					echo '<li><a href="mailto:'. $instance['email'] .'" class="mico-widget-contact-info-email">' . $instance['email'] . '</a></li>';
				}

				echo '</ul>';

			echo '</div>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {
		// Output admin widget options form
		
		$image_id = ! empty( $instance['image_id'] ) ? $instance['image_id'] : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Contact us', 'mico-contact-widget' );
		
		$name = ! empty( $instance['name'] ) ? $instance['name'] : '';
		$phone = ! empty( $instance['phone'] ) ? $instance['phone'] : '';
		$email = ! empty( $instance['email'] ) ? $instance['email'] : '';
		
		?>
		<p>
			<div class="mico-contact-widget-image-container" style="margin-bottom: 5px;">
				<?php if ( !empty( $instance['image_id']) ): ?>
					<?php $image = wp_get_attachment_image_src( $image_id, 'medium' ); ?>
					<img src="<?php echo $image[0] ?>" alt="" style="max-width:100%; display:block;">
				<?php endif ?>
			</div>
			<input class="widefat mico-contact-widget-media-input" type="hidden" id="<?php echo $this->get_field_id( 'image_id' ); ?>" name="<?php echo $this->get_field_name( 'image_id' ); ?>" value="<?php echo esc_attr( $image_id ); ?>">
			<button class="mico-contact-widget-media-button button">
				<?php _e('Choose image', 'mico-contact-widget'); ?>
			</button>
			<?php if ( !empty( $instance['image_id']) ): ?>
				<button class="mico-contact-widget-remove-image button">
					<?php _e('Remove Image', 'mico-contact-widget'); ?>
				</button>
			<?php endif; ?>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'mico-contact-widget' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e( 'Name:', 'mico-contact-widget' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', 'mico-contact-widget' ); ?></label> 
			<input type="tel" class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>"  value="<?php echo esc_attr( $phone ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', 'mico-contact-widget' ); ?></label> 
			<input type="email" class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>">
		</p>
		


		<?php 
		
	}

	/**
	 * Sanitize and save widget form values.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['image_id'] = ( ! empty( $new_instance['image_id'] ) ) ? strip_tags( $new_instance['image_id'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['name'] = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : '';
		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
		return $instance;
	}
}