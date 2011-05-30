<div class="block small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Tweet</h2>
        <ul>
            <li>Total Reach: <?php echo $total ?></li>
        </ul>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
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
                <?php foreach ($retweet as $r): ?>
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

<div class="block small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Tweet</h2>
    </div>
    <div class="block_content">
       Total Reach: <?php echo $total ?>


    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
<!-- .login ends -->
