<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>User : <?php echo $tweep->screen_name ?></h2>
        <ul>
            <li><a href="<?php echo site_url('tweep/index/' . $tweep->user_id) ?>">Status</a></li>
            <li><a href="<?php echo site_url('tweep/keyword/' . $tweep->user_id) ?>">WordCloud</a></li>
            <li><a href="<?php echo site_url('tweep/mention/' . $tweep->user_id) ?>">Mention</a></li>
            <li class="active">User</li>

        </ul>
    </div>
    <div class="block_content">
        <h3>Top 10 User Mention</h3>
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th style="width:50px;">&nbsp;</th>
                    <th>User</th>
                    <th style="width: 150px;">&nbsp;</th>
                    <th style="width: 150px;">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($mentions as $r): ?>
                    <tr>
                        <td><img src="<?php echo $r->profile_image_url ?>" alt="<?php echo $r->screen_name ?>"/></td>
                        <td>
                            <h4><?php echo $r->screen_name ?></h4>
                            <?php echo $r->description ?>
                        </td>
                        <td style="text-align: right"><?php echo $r->followers_count ?> followers</td>
                        <td style="text-align: right"><strong><?php echo $r->total ?></strong> mentions</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <!-- /table -->

        <p>&nbsp;</p>

        <h3>Top 10 User Mentioned</h3>
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th style="width:50px;">&nbsp;</th>
                    <th>User</th>
                    <th style="width: 150px;">&nbsp;</th>
                    <th style="width: 150px;">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($mentioneds as $r): ?>
                    <tr>
                        <td><img src="<?php echo $r->profile_image_url ?>" alt="<?php echo $r->screen_name ?>"/></td>
                        <td>
                            <h4><?php echo $r->screen_name ?></h4>
                            <?php echo $r->description ?>
                        </td>
                        <td style="text-align: right"><?php echo $r->followers_count ?> followers</td>
                        <td style="text-align: right"><strong><?php echo $r->total ?></strong> mentions</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <!-- /table -->
        <p>&nbsp;</p>



    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
