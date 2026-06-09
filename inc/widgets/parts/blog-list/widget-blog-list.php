<?php

/*
 * Adds Shadhin_plugins_Widget_BlogList widget.
 */
if( !class_exists( 'Shadhin_plugins_Widget_BlogList' ) ) {
class Shadhin_plugins_Widget_BlogList extends Shadhin_plugins_Widget_Loader {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$this->widgetOptions = array(
			'classname'		=> 'widget-blog-list clearfix',
			'description'	=> esc_html__( 'A widget that displays list of blog posts.', 'shadhin-plugins' ),
		);
		parent::__construct( 'mh_widget_blog_list', esc_html__( '(TM) Latest News', 'shadhin-plugins' ), $this->widgetOptions );
		$this->getFormFields();
	}


	/**
	 * Get form fields of the widget.
	 */
	protected function getFormFields() {
		$this->formFields = array(
			array(
				'id'		=> 'title',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Widget Title:', 'shadhin-plugins' ),
				'desc'		=> '',
				'default'	=> esc_html__( 'Latest News', 'shadhin-plugins' ),
			),
			array(
				'id'		=> 'custom_css_class',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Custom CSS Class:', 'shadhin-plugins' ),
				'desc'		=> esc_html__( 'To style particular content element', 'shadhin-plugins' ),
			),
			array(
				'id'		=> 'num_of_posts',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Number of Posts:', 'shadhin-plugins' ),
				'desc'		=> '',
			),
			array(
				'id'		=> 'limit_title_words',
				'type'		=> 'text',
				'title'		=> esc_html__( 'Limit number of words to display in title:', 'shadhin-plugins' ),
				'desc'		=> '',
			),
			array(
				'id'		=> 'blog_category',
				'type'		=> 'dropdown',
				'title'		=> esc_html__( 'Blog Category:', 'shadhin-plugins' ),
				'desc'		=> '',
				'options'	=> shadhin_plugins_get_post_all_categories_array()
			),
			array(
				'id'		=> 'order_by',
				'type'		=> 'dropdown',
				'title'		=> esc_html__( 'Order By:', 'shadhin-plugins' ),
				'desc'		=> '',
				'options'	=> array(
					'title'		=> esc_html__( 'Title', 'shadhin-plugins' ),
					'date'			=> esc_html__( 'Date', 'shadhin-plugins' ),
					'comment_count' => esc_html__( 'Number of Comments', 'shadhin-plugins' )
				)
			),
			array(
				'id'		=> 'order',
				'type'		=> 'dropdown',
				'title'		=> esc_html__( 'Order:', 'shadhin-plugins' ),
				'desc'		=> '',
				'options'	=> array(
					'DESC' => esc_html__( 'DESC', 'shadhin-plugins' ),
					'ASC'  => esc_html__( 'ASC', 'shadhin-plugins' )
				)
			),
			array(
				'id'		=> 'disable_thumb',
				'type'		=> 'checkbox',
				'title'		=> esc_html__( 'Disable Thumbnail', 'shadhin-plugins' ),
				'desc'		=> '',
				'value'	=> 'on',
			),
			array(
				'id'		=> 'post_title_tag',
				'type'		=> 'dropdown',
				'title'		=> esc_html__( 'Post Title Tag:', 'shadhin-plugins' ),
				'desc'		=> '',
				'options'	=> array(
					'h6' => 'h6',
					'h5' => 'h5',
					'h4' => 'h4',
					'h3' => 'h3',
					'h2' => 'h2',
				)
			),
		);
	}



	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args	 Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo wp_kses_post($args['before_widget']);

		if ( ! empty( $instance['title'] ) ) {
			echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
		}

		//default posts per page
		$posts_per_page = ( $instance['num_of_posts'] == '' ) ? -1 : $instance['num_of_posts'];
		//query args
		$query_args = array(
			'orderby' => $instance['order_by'],
			'order' => $instance['order'],
			'category__in' => $instance['blog_category'],
			'posts_per_page' => $posts_per_page,
		);

		$the_query = new \WP_Query( $query_args );
		$instance['the_query'] = $the_query;

		$instance['disable_thumb'] = isset($instance['disable_thumb']) ? $instance['disable_thumb'] : '';

		//Produce HTML version by using the parameters (filename, variation, folder name, parameters, widget_ob_start)
		$html = shadhin_plugins_get_widget_template_part( 'blog-list', null, 'blog-list/tpl', $instance, false );

		echo wp_kses_post($args['after_widget']);
	}
}
}