<?php
namespace JLTFLICKR\Inc\Classes;

class Flickr_Widget extends \WP_Widget{
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Constructor
	 *
	 * @return Jewel_Flickr
	 */
	function __construct(){
		$this->defaults = array(
			'title'     => '',
			'type'      => 'user',
			'flickr_id' => '',
			'display'   => 'latest',
			'limit'     => 9,
			'size'      => 's',
			'coloumn'=> '2'
		);

		parent::__construct(
			'jewel-flickr-widget',
			esc_html__( 'Jewel Flickr', 'jewelf' ),
			array(
				'classname'   => 'jewel-flickr-widget',
				'description' => esc_html__( 'Display Flickr photos.', 'jewelf' )
			)
		);
	}

	/**
	 * Display widget
	 *
	 * @param array $args     Sidebar configuration
	 * @param array $instance Widget settings
	 *
	 * @return void
	 */
	function widget( $args, $instance )
	{
		$instance = wp_parse_args( $instance, $this->defaults );

		extract( $args );

		echo $before_widget;

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) )
			echo $before_title . $title . $after_title;

		echo '<div class="jewel-flickr-photos jewel-size-' . esc_attr( $instance['size'] ) . ' jltflickr-0-'.esc_attr( $instance['coloumn']).'">';

		if ( ! empty( $instance['flickr_id'] ) ){
			$src = add_query_arg(
				array(
					'count'           => $instance['limit'],
					'display'         => $instance['display'],
					'size'            => $instance['size'],
					'source'          => $instance['type'],
					'coloumn'         => $instance['coloumn'],
					$instance['type'] => $instance['flickr_id'],

					'layout'          => 'x',
				),
				'http://www.flickr.com/badge_code_v2.gne'
			);
			echo '<script src="' . esc_url( $src ) . '"></script>';
		}
		else
		{
			echo '<p>' . esc_html__( 'Please provide an Flickr ID', 'jewelf' ) . '</p>';
		}

		echo '</div>';

		echo $after_widget;
	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New widget settings
	 * @param array $old_instance Old widget settings
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance )
	{
		$new_instance['title'] = strip_tags( $new_instance['title'] );
		$new_instance['limit'] = intval( $new_instance['limit'] );
		$new_instance['coloumn'] = intval( $new_instance['coloumn'] );

		return $new_instance;
	}

	/**
	 * Display widget settings
	 *
	 * @param array $instance Widget settings
	 *
	 * @return void
	 */
	function form( $instance )
	{
		$instance = wp_parse_args( $instance, $this->defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'jewelf' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ); ?>"><?php esc_html_e( 'Flickr ID', 'jewelf' ); ?></label>
			(<a href="http://idgettr.com" target="_blank"><?php esc_html_e( 'Get your Flickr ID here', 'jewelf' ) ?></a>)
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'flickr_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'flickr_id' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['flickr_id'] ); ?>">
		</p>

		<p>
			<select id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
				<option value="user" <?php selected( 'user', $instance['type'] ) ?>><?php esc_html_e( 'User', 'jewelf' ) ?></option>
				<option value="group" <?php selected( 'group', $instance['type'] ) ?>><?php esc_html_e( 'Group', 'jewelf' ) ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Type', 'jewelf' ); ?></label>
		</p>

		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['limit'] ); ?>" size="2">
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Number of photos', 'jewelf' ); ?></label>
		</p>

		<p>
			<select id="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display' ) ); ?>">
				<option value="latest" <?php selected( 'latest', $instance['display'] ) ?>><?php esc_html_e( 'Latest', 'jewelf' ) ?></option>
				<option value="random" <?php selected( 'random', $instance['display'] ) ?>><?php esc_html_e( 'Random', 'jewelf' ) ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>"><?php esc_html_e( 'Display', 'jewelf' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'coloumn' ) ); ?>"><?php esc_html_e( 'Number of Coloumns (Max 5)', 'jewelf' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'coloumn' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'coloumn' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['coloumn'] ); ?>" size="2">	
		</p>
		<p>
			<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>">
				<option value="s" <?php selected( 's', $instance['size'] ) ?>><?php esc_html_e( 'Standard', 'jewelf' ) ?></option>
				<option value="t" <?php selected( 't', $instance['size'] ) ?>><?php esc_html_e( 'Thumbnail', 'jewelf' ) ?></option>
				<option value="m" <?php selected( 'm', $instance['size'] ) ?>><?php esc_html_e( 'Medium', 'jewelf' ) ?></option>
			</select>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Size', 'jewelf' ); ?></label>
		</p>
	<?php

	}

}