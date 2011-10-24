<div class="block small left">
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
			<th>Name</th>
			<th>Username</th>
			<th>Email</th>
			<th>Group</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo $user['first_name']?> <?php echo $user['last_name']?></td>
				<td><?php echo $user['username']?></td>
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

<div class="block small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>User Log</h2>
    </div>
    <div class="block_content">
        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>User</th>
					<th>Group</th>
                    <th>Latest Update</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($latestupdate as $s): ?>
                    <tr>
                        <td><a href=""><?php echo anchor('mydashboard/logs/'.$s->id.'/',$s->username) ?></a></td>
                        <td><?php echo  $s->description ?></td>
                        <td><?php echo  $s->log_date ?></td>
                        <td>&nbsp;</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
	
</div>