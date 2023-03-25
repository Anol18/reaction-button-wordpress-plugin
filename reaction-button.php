<?php
/** 
* Plugin Name: Reaction Button
* Description: A Custom WordPress plugin that displays three reaction icons: 'smile,' 'straight,' and 'sad'. User can react on post or page
* Version: 1.0.0
* Author: WP Developer
* Author URI: https://wpdeveloper.com/
*/
if (!defined('ABSPATH')) {
    header("Location: /");
    die();
}

function reaction_button_activation(){
    global $wpdb, $table_prefix;
    
    $wp_reaction_table = $table_prefix.'reaction';

    $sql = "CREATE TABLE IF NOT EXISTS `$wp_reaction_table` (`id` INT NOT NULL AUTO_INCREMENT ,`title` TEXT NULL,`type` TEXT NULL, `smile` INT NULL , `straight` INT NULL , `sad` INT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";

    $wpdb->query($sql);
   
}
// Activation Hook
register_activation_hook(__FILE__,"reaction_button_activation");



function reaction_button_deactivation(){
    global $wpdb, $table_prefix;

    $wp_reaction_table = $table_prefix.'reaction';

    $sql = "TRUNCATE TABLE `$wp_reaction_table`";

    $wpdb->query($sql);
}
// Deactivation Hook
register_deactivation_hook(__FILE__,"reaction_button_deactivation");


function reaction_button_shortcode(){
    global $wpdb,$post,$table_prefix;
    $wp_reaction_table = $table_prefix.'reaction';
    $post_id = $post->ID;
    $post_title = $post->post_title;
    $page_id='';
    $page_title = '';

    if(is_page()){
        $page_id =  get_queried_object_id();
        $page_title = get_the_title($page_id);

        $data = array(
        'id' =>  $page_id,
        'title' =>   $page_title,
        'type'=> 'Page',
        'smile' => 0,
        'straight' => 0,
        'sad' => 0
    );
     $wpdb->insert($wp_reaction_table,$data);
    }
    else{
         $data = array(
        'id' =>   $post_id,
        'title' =>  $post_title,
        'type'=> 'Post',
        'smile' => 0,
        'straight' => 0,
        'sad' => 0
    );
     $wpdb->insert($wp_reaction_table,$data);
    }
  
        include 'public/public-reaction-emojis.php';
  
}
// add short code and initilize reaction database
add_shortcode('wp-developer-2023','reaction_button_shortcode');


function custom_scripts(){
    $js_path = plugins_url('js/main.js',__FILE__);
    $path_style =  plugins_url('js/main.js',__FILE__);
    $dep = array('jquery');
    $js_ver = filemtime(plugin_dir_path(__FILE__).'js/main.js'); 
    $style_ver =  filemtime(plugin_dir_path(__FILE__).'css/style.css'); 
    $style_path = plugins_url('css/style.css',__FILE__);
    
    // wp_enqueue_style('custom-style',$path_style,'',$style_ver);
     wp_enqueue_style( 'custom-style',  $style_path,'',$style_ver );
    wp_enqueue_script('custom-js',$js_path, $dep, $js_ver, true);
    wp_add_inline_script('custom-js','var ajaxUrl = "'.admin_url('admin-ajax.php').'";','before'); 
}
add_action('wp_enqueue_scripts','custom_scripts');



function reaction_button_dashboard_function(){
    include 'admin/main-page.php';
}

function plugin_menu(){
    add_menu_page('Reaction Button Dashboard', 'Reaction','manage_options','Reaction-button','reaction_button_dashboard_function','',6);
}
// Add admin menu
add_action("admin_menu","plugin_menu");

     
function update_reaction_value()
{
    global $wpdb, $table_prefix;
    $table_name = $table_prefix.'reaction';


    $column_name = $_POST['column_name']; 
    $id= $_POST['post_id'];

    $wpdb->query("UPDATE $table_name SET $column_name = $column_name + 1 WHERE id = $id");

    
    $sql = "SELECT * FROM `$table_name`;";
    $result = $wpdb->get_results($sql);
  
    ob_start();
?>
  

<?php  foreach($result as $row):   ?>
    <?php  if($row->id == $id): ?>
    
  <input type="hidden" id='post-value' name='post-data' value=<?php echo $id ?> >
    <button  type='submit'  id='smile' class="off">😊<span id="val"><?php echo $row->smile; ?></span></button>
    <button  type='submit' id='straight' class="off">😐<span><?php echo $row->straight; ?></span></button>
    <button type='submit' id='sad' class="off">🥲<span><?php echo $row->sad; ?></span></button>

    <?php    endif; ?>
    <?php  endforeach; ?> 
 
<?php
echo ob_get_clean();
     
    wp_die(); 

}

add_action('wp_ajax_update_reaction_value', 'update_reaction_value');  

?>



