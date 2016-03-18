<div class="user-profile">

  <div class="avatar text-center">

    <div class="upload-image user-type">

  <div class="image-wrap text-center">
    <img class="img-responsive" src="<?= strlen($u_photo)>0?$u_photo:asset_base_url().'/images/emp.jpg'?>" width="100">

  </div>

</div>

  </div>

  <div class="account-info">
    <div class="row">
      <div class="col-xs-2 col-xs-offset-3">First Name:</div>
      <div class="col-xs-6 ng-binding">
        <?= $u_fname?>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-2 col-xs-offset-3">Last Name:</div>
      <div class="col-xs-6 ng-binding">
        <?= $u_lname?>
      </div>
    </div>

    <div class="row">

      <div class="col-xs-2 col-xs-offset-3">Email:</div>
      <div class="col-xs-6">
        <?= $u_email?>
      </div>
    </div>
    <div class="row">

      <div class="col-xs-2 col-xs-offset-3">Password:</div>
      <div class="col-xs-6">
        <?php 
          for ($i=0; $i<strlen($u_password); $i++) {
            echo "*";
          }
        ?>
      </div>

    </div>
    <div class="row">

      <div class="col-xs-2 col-xs-offset-3">Bio:</div>

      <div class="col-xs-6">
        <?= $u_bio?>
      </div>
    </div>
  </div>

  <div class="misc text-center">
    <a href="<?php echo site_url('profile/edit')?>" class="btn btn-secondary">Edit Profile</a>
  </div>

  <div class="social">
    <div class="row">

      <div class="col-xs-2 col-xs-offset-3">
        User Role:
      </div>

      <div class="col-xs-6">
<?php
  if ($u_type == 1) echo "Admin";
  else if ($u_type == 2) echo "Advisor";
  else echo "Startup";
?>
      </div>

    </div>
  </div>
  <div class="social">
    <div class="row">

      <div class="col-xs-2 col-xs-offset-3">
        Facebook:
      </div>

      <div class="col-xs-6">
        <?= $u_facebook?>
      </div>

    </div>
  </div>

</div>