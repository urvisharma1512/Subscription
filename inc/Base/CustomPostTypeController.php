<?php 
/**
 * @package   SubscriptionProduct
*/
namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\MetaboxCallbacks;

/**
* 
*/
class CustomPostTypeController extends BaseController
{
	public $settings;

	public $callbacks;

	public $cpt_callbacks;

	public $subpages = array();

	public $custom_post_types = array();
	
	public function register()
	{
		if ( ! $this->activated( 'cpt_manager' ) ) return;

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->cpt_callbacks = new CptCallbacks();
		$this->metabox_callbacks = new MetaboxCallbacks();

		$this->setSubpages();

		$this->setSettings();

		$this->setSections();

		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();

		$this->storeCustomPostTypes();

		if ( ! empty( $this->custom_post_types ) ) {
			add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
			//metabox for product cpt
			add_action('add_meta_boxes', array($this,'registerMetaBox') );
			add_action('save_post', array($this,'saveMetaBox') );
			//columns for product cpt
			add_action('manage_product_posts_columns', array($this, 'set_custom_columns'));
			add_action( 'manage_product_posts_custom_column', array( $this, 'set_custom_columns_data' ),10,2 );
			add_filter( 'manage_edit-product_sortable_columns', array( $this, 'set_custom_columns_sortable' ) ); 
			//pages for product  post
			add_shortcode("show_product_page", array($this, 'show_product_page_function') );
			add_shortcode("cart_page", array($this, 'cart_page_function') );
			add_shortcode("checkout_page", array($this, 'checkout_page_function') );
	    }
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'subscription_product', 
				'page_title' => 'Custom Post Types', 
				'menu_title' => 'CPT Manager', 
				'capability' => 'manage_options', 
				'menu_slug' => 'subscription_product_cpt', 
				'callback' => array( $this->callbacks, 'adminCpt' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'subscription_product_cpt_settings',
				'option_name' => 'subscription_product_cpt',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'subscription_product_cpt_index',
				'title' => 'Custom Post Type Manager',
				'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
				'page' => 'subscription_product_cpt'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'post_type',
				'title' => 'Custom Post Type ID',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'subscription_product_cpt',
				'section' => 'subscription_product_cpt_index',
				'args' => array(
					'option_name' => 'subscription_product_cpt',
					'label_for' => 'post_type',
					'placeholder' => 'eg. product',
					'array' => 'post_type'
				)
			),
			array(
				'id' => 'singular_name',
				'title' => 'Singular Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'subscription_product_cpt',
				'section' => 'subscription_product_cpt_index',
				'args' => array(
					'option_name' => 'subscription_product_cpt',
					'label_for' => 'singular_name',
					'placeholder' => 'eg. Product',
					'array' => 'post_type'
				)
			),
			array(
				'id' => 'plural_name',
				'title' => 'Plural Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'subscription_product_cpt',
				'section' => 'subscription_product_cpt_index',
				'args' => array(
					'option_name' => 'subscription_product_cpt',
					'label_for' => 'plural_name',
					'placeholder' => 'eg. Products',
					'array' => 'post_type'
				)
			),
			array(
				'id' => 'public',
				'title' => 'Public',
				'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
				'page' => 'subscription_product_cpt',
				'section' => 'subscription_product_cpt_index',
				'args' => array(
					'option_name' => 'subscription_product_cpt',
					'label_for' => 'public',
					'class' => 'ui-toggle',
					'array' => 'post_type'
				)
			),
			array(
				'id' => 'has_archive',
				'title' => 'Archive',
				'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
				'page' => 'subscription_product_cpt',
				'section' => 'subscription_product_cpt_index',
				'args' => array(
					'option_name' => 'subscription_product_cpt',
					'label_for' => 'has_archive',
					'class' => 'ui-toggle',
					'array' => 'post_type'
				)
			)
		);

		$this->settings->setFields( $args );
	}

	public function storeCustomPostTypes()
	{
		$options = get_option('subscription_product_cpt') ?: array();
		foreach ($options as $option) {

			$this->custom_post_types[] = array(
				'post_type'             => $option['post_type'],
				'name'                  => $option['plural_name'],
				'singular_name'         => $option['singular_name'],
				'menu_name'             => $option['plural_name'],
				'name_admin_bar'        => $option['singular_name'],
   				'archives'              => $option['singular_name'] . ' Archives',
				'attributes'            => $option['singular_name'] . ' Attributes',
				'parent_item_colon'     => 'Parent ' . $option['singular_name'],
				'all_items'             => 'All ' . $option['plural_name'],
				'add_new_item'          => 'Add New ' . $option['singular_name'],
				'add_new'               => 'Add New',
				'new_item'              => 'New ' . $option['singular_name'],
				'edit_item'             => 'Edit ' . $option['singular_name'],
				'update_item'           => 'Update ' . $option['singular_name'],
				'view_item'             => 'View ' . $option['singular_name'],
				'view_items'            => 'View ' . $option['plural_name'],
				'search_items'          => 'Search ' . $option['plural_name'],
				'not_found'             => 'No ' . $option['singular_name'] . ' Found',
				'not_found_in_trash'    => 'No ' . $option['singular_name'] . ' Found in Trash',
				'featured_image'        => $option['singular_name']. ' Image',
				'set_featured_image'    => 'Set ' .$option['singular_name']. ' Image',
				'remove_featured_image' => 'Remove ' .$option['singular_name']. ' Image',
				'use_featured_image'    => 'Use' .$option['singular_name']. 'Image',
				'insert_into_item'      => 'Insert into ' . $option['singular_name'],
				'uploaded_to_this_item' => 'Upload to this ' . $option['singular_name'],
				'items_list'            => $option['plural_name'] . ' List',
				'items_list_navigation' => $option['plural_name'] . ' List Navigation',
				'filter_items_list'     => 'Filter' . $option['plural_name'] . ' List',
				'label'                 => $option['singular_name'],
				'description'           => $option['plural_name'] . 'Custom Post Type',
				'supports'              => array( 'title', 'editor', 'thumbnail'),
				'taxonomies'            => array( 'category', 'post_tag' ),
				'hierarchical'          => false,
				'public'                => isset($option['public']) ?: false,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => isset($option['has_archive']) ?: false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post'
			);
		}
	}

	public function registerCustomPostTypes()
	{
		foreach ($this->custom_post_types as $post_type) {
			register_post_type( $post_type['post_type'],
				array(
					'labels' => array(
						'name'                  => $post_type['name'],
						'singular_name'         => $post_type['singular_name'],
						'menu_name'             => $post_type['menu_name'],
						'name_admin_bar'        => $post_type['name_admin_bar'],
						'archives'              => $post_type['archives'],
						'attributes'            => $post_type['attributes'],
						'parent_item_colon'     => $post_type['parent_item_colon'],
						'all_items'             => $post_type['all_items'],
						'add_new_item'          => $post_type['add_new_item'],
						'add_new'               => $post_type['add_new'],
						'new_item'              => $post_type['new_item'],
						'edit_item'             => $post_type['edit_item'],
						'update_item'           => $post_type['update_item'],
						'view_item'             => $post_type['view_item'],
						'view_items'            => $post_type['view_items'],
						'search_items'          => $post_type['search_items'],
						'not_found'             => $post_type['not_found'],
						'not_found_in_trash'    => $post_type['not_found_in_trash'],
						'featured_image'        => $post_type['featured_image'],
						'set_featured_image'    => $post_type['set_featured_image'],
						'remove_featured_image' => $post_type['remove_featured_image'],
						'use_featured_image'    => $post_type['use_featured_image'],
						'insert_into_item'      => $post_type['insert_into_item'],
						'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
						'items_list'            => $post_type['items_list'],
						'items_list_navigation' => $post_type['items_list_navigation'],
						'filter_items_list'     => $post_type['filter_items_list']
					),
					'label'                     => $post_type['label'],
					'description'               => $post_type['description'],
					'supports'                  => $post_type['supports'],
					'taxonomies'                => $post_type['taxonomies'],
					'hierarchical'              => $post_type['hierarchical'],
					'public'                    => $post_type['public'],
					'show_ui'                   => $post_type['show_ui'],
					'show_in_menu'              => $post_type['show_in_menu'],
					'menu_position'             => $post_type['menu_position'],
					'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
					'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
					'can_export'                => $post_type['can_export'],
					'has_archive'               => $post_type['has_archive'],
					'exclude_from_search'       => $post_type['exclude_from_search'],
					'publicly_queryable'        => $post_type['publicly_queryable'],
					'capability_type'           => $post_type['capability_type']
				)
			);
		}
	}
	public function registerMetaBox(){
		foreach ($this->custom_post_types as $post_type) {
			add_meta_box("meta-box-id", $post_type['singular_name']. " Details",array( $this->metabox_callbacks, 'metaBoxCallback' ),  $post_type['post_type']);
		}
	}
	public function saveMetaBox($post_id){
		if (! isset($_POST['metabox_key_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['metabox_key_nonce'];
		if (! wp_verify_nonce( $nonce, 'metabox_key' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		$data = array(
			'price' => sanitize_text_field($_POST['price']), 
			'sale_price' => sanitize_text_field($_POST['sale_price']),      	
			'sku' => sanitize_text_field($_POST['sku']),
			'stock_status' => sanitize_text_field($_POST['stock_status']),        	
			'sub_per_interval' => sanitize_text_field($_POST['sub_per_interval']), 
        	'sub_expiry' => sanitize_text_field($_POST['sub_expiry']),
			'sub_entry_fee' => sanitize_text_field($_POST['sub_entry_fee']),
        	'sub_free_trial' => sanitize_text_field($_POST['sub_free_trial']),
		);
		update_post_meta( $post_id, '_metabox_key', $data );
	}
	//adding columns in product custom post
	public function set_custom_columns($columns)
	{
		$date = $columns['date'];
		unset($columns['date']);
		//rearraging columns
		$columns['price'] = 'Price';
		$columns['stock_status'] = 'In Stock';
		$columns['date'] = $date;
		return $columns;
	}
	//column sorting functionality in product custom post
	public function set_custom_columns_data($column, $post_id)
	{
		$data = get_post_meta( $post_id, '_metabox_key', true );
		$price = isset($data['price']) ? $data['price'] : '';
        $stock_status = isset($data['stock_status']) ? $data['stock_status'] : '';
		switch($column) {
			case 'price':
				echo '<strong>' . $price . '</strong><br/>';
				break;

			case 'stock_status':
				echo $stock_status;
				break;
		}
		
	}
	//sortable columns 
	public function set_custom_columns_sortable($columns)
	{
		$columns['price'] = 'price';
		$columns['stock_status'] = 'stock_status';
		return $columns;
	}

	//creating product pages 
	function show_product_page_function(){
		return require_once( "$this->plugin_path/templates/Frontend/products.php" );  
	}
	//creating cart pages 
	function cart_page_function(){
		return require_once( "$this->plugin_path/templates/Frontend/cart.php" );  
	}
    //creating checkout pages 
	function checkout_page_function(){
		return require_once( "$this->plugin_path/templates/Frontend/checkout.php" );  
	}
}