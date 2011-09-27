<div class="block left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Users</h2>
    </div>		
    <!-- .block_head ends -->


    <div class="block_content">
	<p>Below is a list of the users. <a href="<?php echo site_url('ionauth/create_user');?>">Create a new user</a></p>
	
	<table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
        <thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Group</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo $user['first_name']?></td>
				<td><?php echo $user['last_name']?></td>
				<td><?php echo $user['email'];?></td>
				<td><?php echo $user['group_description'];?></td>
				<td><?php echo ($user['active']) ? anchor("ionauth/deactivate/".$user['id'], 'Active') : anchor("ionauth/activate/". $user['id'], 'Inactive');?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	
    </div>		<!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		<!-- .login ends -->