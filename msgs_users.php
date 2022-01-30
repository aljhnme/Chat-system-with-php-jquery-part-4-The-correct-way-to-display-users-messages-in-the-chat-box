<?php 

include 'mysqli.php';
session_start();

if (isset($_POST['last_msg_chat_id'])) 
{
  $show_last_msg="AND chat_id > '".$_POST['last_msg_chat_id']."'";
}else{
  $show_last_msg="";
}

$query="SELECT * FROM `chat` where(us_m=:user_id_sess AND us_r=:user_id_ch $show_last_msg) 
                                  OR 
                                  (us_r=:user_id_sess AND us_m=:user_id_ch $show_last_msg)";



$stm=$connect->prepare($query);
$data=array(':user_id_sess' => $_SESSION['user_id'],
            ':user_id_ch'  => $_POST['user_click_id']);

$stm->execute($data);
$fetch_msgs=$stm->FetchAll();

foreach ($fetch_msgs as $row) 
{
  if ($row['us_m'] == $_SESSION['user_id']) 
  {
  	 ?>
       <div class="message message-personal new">
       	<?php echo $row['msg'];?>
       </div>
  	 <?php
  }

  if ($row['us_m'] != $_SESSION['user_id']) 
  {
  	 ?>
      <div class="message new">
		<?php echo $row['msg'];?>
	  </div>
  	 <?php
  }
  ?>
  <input type="hidden" class="last_msg" id="<?php echo $row['chat_id'];?>">
<?php
}
?>