<?php
  if(!defined('ABSPATH')){
        header("Location: /");
        die();
    }
    global $wpdb, $table_prefix, $post,$id ;

    $wp_reaction = $table_prefix.'reaction';
 



if(is_page())
{
     $id =  get_queried_object_id();
}
else{
    $id = $post->ID;
}


$sql = "SELECT * FROM `$wp_reaction`;";
$result = $wpdb->get_results($sql);
   
   


    
ob_start();
?>

<div class="warp reaction-icons" id="reaction-section">
 
 
<?php  foreach($result as $row):  ?>
   
  
<?php  if($row->id == $id): ?>
    
        <input type="hidden" id='post-value' name='post-data' value=<?php echo $id ?> >
    <button  type='submit'  id='smile' class="off">😊<span id="val"><?php echo $row->smile; ?></span></button>
    <button  type='submit' id='straight' class="off">😐<span><?php echo $row->straight; ?></span></button>
    <button type='submit' id='sad' class="off">🥲<span><?php echo $row->sad; ?></span></button>
   
   <?php  endif; ?>
<?php endforeach; ?>
</div> 


<?php
echo ob_get_clean();

?>
