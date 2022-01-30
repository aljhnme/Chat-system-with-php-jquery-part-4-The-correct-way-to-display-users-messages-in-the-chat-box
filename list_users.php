<?php 
$query="SELECT * FROM `tb_user` where user_id != '".$_SESSION['user_id']."'";

$stm=$connect->prepare($query);
$stm->execute();
$row_f=$stm->FetchAll();

foreach ($row_f as $row) 
{
	if ($row['img_user'] != "") 
	{
	 $img_pro=$row['img_user'];
	}else{
	 $img_pro="male-profile.jpg";
	}
?>
<li class="list-group-item click_send" id="<?php echo $row['user_id'];?>">
  <div class="row">
    <div class="col-md-12 col-12">
     <div class="row">
       <div class="col-md-4 col-4 user-img text-center pt-1">
        <img src="<?php echo $img_pro;?>" alt="Seth Frazier" class="img-responsive img-circle rounded-circle" id="img_pro<?php echo$row['user_id'];?>"/>
      </div>
      <div class="col-md-8 col-8">
       <span class="font-weight-bold mb-1" id="userm<?php echo $row['user_id'];?>"><?php echo $row['username'];?></span>
     </div>
    </div>
   </div>
  </div>
</li>
<?php
}
?>