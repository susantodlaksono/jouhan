<style type="text/css">
   .notif-summary{
      font-size: 10.5px;
      margin-top: -25px;
   }   
   .profile-info.dropdown .dropdown-menu{
      margin-left: -72px;
      margin-top: -1px;
   }
</style>

<div class="row">
   <div class="col-md-9 col-sm-5 clearfix" style="border-right:1px solid #black;height:50px;padding-left:10px;">
      <img src="<?php echo base_url() ?>indosiar.png" width="50" height="50" class="pull-left">
      <h3 class="pull-left ebdesk-title">Jouhan</h3><br>
      <p class="ebdesk-subtitle">Jual Beli Louhan - <b><?php echo config_item('cluster') ?></b></p>
   </div>
   <!-- <div class="col-md-6 col-sm-5 clearfix" style="border-right:0px solid #e6e6e6;height:50px;">
      <div class="input-group" style="margin-top:9px;margin-bottom: 9px;">
         <input type="text" class="form-control" name="search" placeholder="Search for something...">
         <div class="input-group-btn">
            <button type="submit" class="btn btn-primary">
               <i class="entypo-search"></i> Search 
            </button>
         </div>
      </div>
   </div> -->
   <!-- <div class="col-md-3 col-sm-2 clearfix text-center" style="border-right:0px solid #e6e6e6;height:50px;">
      <h5 class="bold" style="margin-top:-2px;">All Role :</h5>
      <span class="label label-default notif-summary">10 Admin</span>
      <span class="label label-default notif-summary">10 Operator</span>
      <span class="label label-default notif-summary">10 Management</span>
   </div> -->
   <div class="col-md-3 col-sm-3 clearfix hidden-xs" style="border:0px solid black;height:50px;">
      <ul class="user-info pull-right pull-none-xsm" style="margin-top:2px;margin-bottom: 9px;">
         <li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <?php 
                  if($avatar){
                     echo '<img src="'.base_url().'/files/user_profil_image/'.$avatar.'" alt="" class="img-circle" width="44">';
                  }else{
                     echo '<img src="'.base_url().'/files/user_profil_image/noavatar.png" alt="" class="img-circle" width="44">';
                  }
               ?>
               <?php echo $username ?>
            </a>
            <ul class="dropdown-menu">
               <!-- Reverse Caret -->
               <li class="caret"></li>
               <li>
                  <a href="<?php echo site_url('security/logout') ?>">
                     <i class="entypo-logout"></i>
                     Logout
                  </a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</div>
<hr />