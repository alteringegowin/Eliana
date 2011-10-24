<div class="block center">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Deactivate User</h2>
    </div>
    <div class="block_content">

<div class='mainInfo'>

	<p>Are you sure you want to deactivate the user '<?php echo $user['username']; ?>'</p>
	
    <?php echo form_open("ionauth/deactivate/".$user['id']);?>
    	
      <p>
      	<label for="confirm">Yes:</label>
		<input type="radio" name="confirm" value="yes" checked="checked" />
      	<label for="confirm">No:</label>
		<input type="radio" name="confirm" value="no" />
      </p>
      
      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(array('id'=>$user['id'])); ?>
      
      <p><?php echo form_submit('submit', 'Submit');?></p>

    <?php echo form_close();?>

</div>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
	
</div>