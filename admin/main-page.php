<?php
  if(!defined('ABSPATH')){
        header("Location: /");
        die();
    }
global $wpdb, $table_prefix;

$wp_reaction = $table_prefix.'reaction';

$sql = "SELECT * FROM `$wp_reaction`;";
$result = $wpdb->get_results($sql);
$count = 0;
ob_start();
?>
<div class="wrap">
    <table class='wp-list-table widefat fixed striped table-view-list pages'>
        <thead>
            <tr>
                <th>SL</th>
                <th>Content Title</th>
                <th>Type</th>

                <th>Smile</th>
                <th>Straight</th>
                <th>Sad</th>
                <th>Total</th>
            </tr>
            <tbody>
              <?php
              foreach($result as $row):
              ?>
                
               
                <tr>
                  <td><?php echo ++$count ?></td>
                   <td><?php echo $row->title; ?></td>
                   <td><?php echo $row->type; ?></td>
                   <td><?php echo $row->smile; ?></td>
                   <td><?php echo $row->straight; ?></td>
                   <td><?php echo $row->sad; ?></td>
                   <td><?php echo $row->smile+$row->straight+$row->sad; ?></td>
                   
                </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </thead>
    </table>
</div>
<?php


echo ob_get_clean();


?>


