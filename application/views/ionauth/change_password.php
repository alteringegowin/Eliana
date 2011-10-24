<div class="block small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Profile</h2>
    </div>
    <div class="block_content">

	<table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
		<?php if(isset($user)): ?>
			<tr>
				<th width="50">Name</th>
				<td width="10">:</td>
				<td><?php echo $user->first_name ?> <?php echo $user->last_name ?></td>
			</tr>
			<tr>
				<th>Username</th>
				<td>:</td>
				<td><?php echo $user->username ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td>:</td>
				<td><?php echo $user->email ;?></td>
			</tr>
			<tr>
				<th>Group</th>
				<td>:</td>
				<td><?php echo $user->group_description ;?></td>
			</tr>
		<?php endif;?>
		</tbody>
	</table>

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
	
</div>

<div class="block small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Change Password</h2>
    </div>
    <div class="block_content">

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("ionauth/change_password");?>

      <p>Old Password:<br />
      <?php echo form_input($old_password);?>
      </p>
      
      <p>New Password:<br />
      <?php echo form_input($new_password);?>
      </p>
      
      <p>Confirm New Password:<br />
      <?php echo form_input($new_password_confirm);?>
      </p>
      
      <?php echo form_input($user_id);?>
      <p><?php echo form_submit('submit', 'Change');?></p>
      
<?php echo form_close();?>

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
	
</div>