<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://exxica.com
 * @since      1.0.0
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Exxica_Simple_Sharing
 * @subpackage Exxica_Simple_Sharing/admin
 * @author     Gaute Rønningen <gaute@exxica.com>
 */
class Exxica_Simple_Sharing_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->name.'-public', plugin_dir_url( __FILE__ ) . 'css/exxica-simple-sharing-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'dashicons' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->name.'-public', plugin_dir_url( __FILE__ ) . 'js/exxica-simple-sharing-public.js', array( 'jquery' ), $this->version, FALSE );

	}

	public function init_shortcodes() {
		add_shortcode('ESSharer', array($this, 'sharing_shortcode'));
	}

	public function sharing_shortcode( $atts ) {
		global $wp, $post;
		$out = "";
		$current_url = get_permalink($post->ID);
		$current_title = get_the_title($post->ID);
		$blogname = get_bloginfo('name');

		$sharers = array(
			array(
				'name' => __('Facebook', 'exxica-simple-sharing'),
				'title' => __('Share article on Facebook', 'exxica-simple-sharing'),
				'url' => sprintf("https://www.facebook.com/sharer/sharer.php?u=%s", urlencode($current_url)),
				'iconCls' => 'dashicons dashicons-facebook'
			),
			array(
				'name' => __('Twitter', 'exxica-simple-sharing'),
				'title' => __('Share article on Twitter', 'exxica-simple-sharing'),
				'url' => sprintf("https://twitter.com/home?status=%s%s", $current_title, '%20'.urlencode($current_url)),
				'iconCls' => 'dashicons dashicons-twitter'
			),
			array(
				'name' => __('Google+', 'exxica-simple-sharing'),
				'title' => __('Share article on Google+', 'exxica-simple-sharing'),
				'url' => sprintf("https://plus.google.com/share?url=%s", urlencode($current_url)),
				'iconCls' => 'dashicons dashicons-googleplus'
			),
			array(
				'name' => __('LinkedIn', 'exxica-simple-sharing'),
				'title' => __('Share article on LinkedIn', 'exxica-simple-sharing'),
				'url' => sprintf("https://www.linkedin.com/shareArticle?mini=true&url=%s&title=%s&source=%s", urlencode($current_url), urlencode($current_title), urlencode($blogname) ),
				'iconCls' => 'dashicons dashicons-networking'
			)
		);

		ob_start();
		?>
		<hr/>
		<br/>
		<strong><?= __('Share article on', 'exxica-simple-sharing') ?></strong>
		<ul class="exxica-simple-sharing-list">
			<?php foreach($sharers as $row) : ?>
			<li class="exxica-simple-sharing-list-item">
				<a class="exxica-simple-sharing-link" href="<?= $row['url'] ?>" target="_blank" title="<?= $row['title'] ?>">
					<span class="<?= $row['iconCls'] ?>"></span> <span class="exxica-simple-sharing-link-text"><?= $row['name'] ?></span>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<br/>
		<hr/>
		<?php
		$out = ob_get_contents();
		ob_end_clean();
		return $out;
	}

	public function insert_sharing_shortcode($content) {

		if(!is_home()) {
			$content .= do_shortcode('[ESSharer]');
		}

		return $content;
	}
}
