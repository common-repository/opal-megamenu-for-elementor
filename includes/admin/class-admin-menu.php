<?php 
defined( 'ABSPATH' ) || exit();

/**
 * @Class Understrap_Core_Admin_Menu
 * 
 * Entry point class to setup load all files and init working on frontend and process something logic in admin
 */
class OSF_Admin_Menu{

	public $page_slug = 'elementor';


	public function __construct () {
		add_action( 'admin_menu' , array( $this, 'register_admin_menu'  ), 99 );

        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 999);
	}

    public function enqueue_scripts(){

    }
    /**
     * Retrieves the admin menu args
     *
     * @return array  Admin menu args
     */
    public function get_admin_menu_args() {

        $menu_name =  __( 'Understrap', 'opalmegamenu');

        return apply_filters( 'opalmegamenu_admin_menu_args', array(
            'name'          => $menu_name,
            'title'         => __('Welcome', 'opalmegamenu'),
            'compatibility' =>    'manage_options',
        ) );
    }

    /**
     * Register the admin menu
     *
     * @return void
     */
    public function register_admin_menu() { 

        $menu_args = $this->get_admin_menu_args();
 
        /*  Register welcome submenu
        /*---------------------------*/
        
       //  echo '<pre>' . print_r( $menu_args ,1 );die;
        add_submenu_page( $this->page_slug,
            $menu_args['title'],
            __('Megamenu Template', 'opalmegamenu'),
            $menu_args['compatibility'],
            'dashboard',
            array( $this, 'render' )
        );
    }

    public function get_header_title(){
        return __( 'Welcome to Use Opal Megamenu', 'opalmegamenu' );
    }
    /**
     * Header section
     *
     * @param  string $type The current tab
     * @return void
     */
    protected function the_header( $type='' ){ 
         
    ?>

        <section class="jumbotron text-center p-4">
            
            <div class="container">
              <h1 class="jumbotron-heading"><?php echo $this->get_header_title(); ?></h1>
              <p class="lead text-muted">Below are same template for megamenu, you select and import it into elementor section template, which you will insert in edit menu profile page.</p>
            </div>
        </section>
        <?php
    }
    public function the_footer(){

    }

    public function the_content(){
        $data = array();    
    ?>
        <?php if( !empty($data) ):?>
        <div class="arow">    
            <?php foreach ( $data as $item ) : ?>
            <div class="col-4">
                    <div class="card" >
                      <img class="card-img-top" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22286%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20286%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1663ec7afa9%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A14pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1663ec7afa9%22%3E%3Crect%20width%3D%22286%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22106.24166488647461%22%20y%3D%2296%22%3E286x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image cap">
                      <div class="card-body">
                        <a href="#" class="btn btn-primary">Import To Library</a>
                      </div>
                    </div>
            </div>    
        <?php endforeach; ?>
        </div>   
        <?php else: ?>
        <div class="megamenu-no-items">
            <h4><?php _e( "No sample data menu for you now, we will update very soon.", "opalmegamenu" ); ?></h4>
        </div>
        <?php endif; ?>
   <?php }
    public function render() { ?>

        <div class="opalmegamenu-admin-menu mr-4">
               <?php echo $this->the_header(); ?> 
              
               <div class="page-menu-content">
                   <div class=""><?php echo $this->the_content(); ?></div>
               </div>
               <?php echo $this->the_footer(); ?>
        </div>
    <?php }
} 

new OSF_Admin_Menu();
?>