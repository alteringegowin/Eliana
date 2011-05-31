<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Tweet</h2>
        <ul>
            <li class="active">Status</li>
            <li><a href="<?php echo site_url('tweep/keyword/' . $tweep->user_id) ?>">WordCloud</a></li>
            <li><a href="<?php echo site_url('tweep/mention/' . $tweep->user_id) ?>">Mention</a></li>
            <li><a href="<?php echo site_url('tweep/user/' . $tweep->user_id) ?>">User</a></li>
        </ul>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Data</th>
                    <th>Followers</th>
                    <th>Last Update</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($replys as $r): ?>
                    <?php $total += $r->followers_count; ?>
                    <tr>
                        <td><img src="<?php echo $r->profile_image_url ?>"/></td>
                        <td>
                            <div><?php echo $r->screen_name ?> (<?php echo $r->name ?>)</div>
                            <div><?php echo $r->tweet_text ?> </div>

                        </td>
                        <td><?php echo $r->followers_count ?></td>
                        <td><?php echo date('Y-m-d H:i', mysql_to_unix($r->created_at)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <!-- /table -->


    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		

