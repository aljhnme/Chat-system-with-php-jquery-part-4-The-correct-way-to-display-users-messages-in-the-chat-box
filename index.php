<!DOCTYPE html>
<html>
<head>
 <style type="text/css">
  .user-img img{
   height: 70px;
   width: 70px;
  }
  .m_g{
    margin-top:111px;
  }
  .list-group-item:hover{
   background: #f1f1f1;
  }
 </style>
 <link rel="stylesheet" type="text/css" href="navbar.css">
 <link rel="stylesheet" type="text/css" href="style_box_chat.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
 <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
 <script type="text/javascript">
 	$(document).ready(function(){
       $(".profile .icon_wrap").click(function(){
           $(this).parent().toggleClass('active');
           $('.notifications').removeClass('active');
       });
       $('.notifications .icon_wrap').click(function(){
          $(this).parent().toggleClass('active');
          $(".profile").removeClass("active");
       });
 	});
 </script>
</head>
<body>
  <?php 
  include 'mysqli.php';
  session_start();
  if (!isset($_SESSION['user_id'])) 
  {
  	header('Location:register.html');
  }
  $query="SELECT * FROM `tb_user` where user_id ='".$_SESSION['user_id']."'";

  $stm=$connect->prepare($query);
  $stm->execute();
  $row=$stm->fetch(PDO::FETCH_ASSOC);
  
  if ($row['img_user'] != "") 
  {
    $img_profile='<img src="'.$row['img_user'].'"/>';
  }else{
  	$img_profile='<img src="male-profile.jpg"/>';
  }
  ?>
  <div class="wrapper">
  	<div class="navbar">
  		<div class="navbar_left">
  	    </div>
  	    <div class="navbar_right">
  	    	<div class="notifications">
  	    	  <div class="icon_wrap">
                  <i class="far fa-comment-alt"></i>
            </div>
           <div class="notification_dd">
            <ul class="notification_ul">
                <li class="starbucks success">
                    <div class="notify_icon">
                        <span class="icon"></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                         **** ****
                        </div>
                        <div class="sub_title">
                         ***************
                        </div>
                    </div>
                </li> 
                 <li class="starbucks success">
                    <div class="notify_icon">
                        <span class="icon"></span>  
                    </div>
                    <div class="notify_data">
                        <div class="title">
                          *****************
                        </div>
                        <div class="sub_title">
                          ******************
                        </div>
                    </div>
                </li> 
            </ul>
        </div>
  	  </div>
  	    <div class="profile">
        <div class="icon_wrap">
          <?php echo $img_profile;?>
          <span class="name"><?php echo $row['username'];?></span>
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="profile_dd">
          <ul class="profile_ul">
            <li><a class="logout" href="logout.php"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
          </ul>
        </div>
      </div>
  	 </div>
  	</div>
  </div>

  <div class="col-md-4 offset-md-4 col-12 m_g">
    <div class="card">
      <ul class="list-group" id="user-list">
        <?php include 'list_users.php'; ?>
      </ul>
    </div>
  </div>
  <?php include 'box_chat.php';?>
</body>
<script type="text/javascript">
  $(document).ready(function(){
     
     var user_click_id;
     setInterval(function(){
       if (typeof user_click_id != "undefined") 
       {
         var last_msg_chat_id=$(".last_msg").last().attr('id');
        $.ajax({
          url:"msgs_users.php",
          type:"post",
          data:{user_click_id:user_click_id,last_msg_chat_id:last_msg_chat_id},
          success:function(data)
          {  
             if (data.trim() != "") 
             {
              $("#msgs_users").append(data);
              $(".messages").scrollTop($(".messages")[0].scrollHeight);
             }
          }
        });
       }
     },1000)

     $('.click_send').click(function(){
        
        $("#msgs_users").html('');

        var user_id=$(this).attr('id');
        user_click_id=user_id;
        var username=$("#userm"+user_id).text();
        var img_user=$("#img_pro"+user_id).attr('src');

        $(".img_profile").attr('src',img_user);
        $(".chat-title").text(username);
        $("#user_id_msg").val(user_id);
        
        $(".box").show();
     });

     $(".insert_msg").click(function(){
          
          var user_id_ch=$("#user_id_msg").val();
          var text_msg=$(".message-input").val();
          var location='insert_msg_user';
          if (text_msg != "") 
          {
           $.ajax({
             url:"action.php",
             type:"POST",
             data:{location:location,user_id_ch:user_id_ch,text_msg:text_msg},
             success:function(data)
             {
               $(".message-input").val('');
             }
          });
         }
      });

     $(".insert_msg").hide();
     $(".message-input").keyup(function()
      {
         if (!this.value == "") 
         {
           $(".insert_msg").show();
         }else{
           $(".insert_msg").hide();
         }
     });
  });
</script>
</html>