<div class="block center">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Create User</h2>
    </div>
    <div class="block_content">

	<p>Please enter the users information below.</p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
    <?php echo form_open("ionauth/create_user");?>
      <p>First Name:<br />
      <?php echo form_input($first_name);?>
      </p>
      
      <p>Last Name:<br />
      <?php echo form_input($last_name);?>
      </p>
      
      <p>Username:<br />
      <?php echo form_input($username);?>
      </p>
      
      <p>Email:<br />
      <?php echo form_input($email);?>
      </p>
      
      <p>Password:<br />
      <?php echo form_input($password);?>
      </p>
      
      <p>Confirm Password:<br />
      <?php echo form_input($password_confirm);?>
      </p>
		
	  <p>Group:<br />
	  <select name="group_id">
		<option value="2">General User</option>
		<option value="1">Administrator</option>
	  </select>
	  </p>
      
      <p><?php echo form_submit('submit', 'Create User');?></p>

      
    <?php echo form_close();?>

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
	
</div>