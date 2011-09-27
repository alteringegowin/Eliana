<div class="block small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Keyword</h2>
    </div>
    <div class="block_content">
        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Keywords</th>
                    <th>Date</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($keywords as $r): ?>
                    <tr>
                        <td><?php echo anchor('mydashboard/tweet/'.$r->id.'/',$r->keyword) ?></td>
                        <td><?php echo  unix_to_human($r->keyword_date) ?></td>
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
<!-- .login ends -->