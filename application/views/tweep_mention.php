<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Mention: <?php echo $tweep->screen_name ?></h2>
        <?php $this->load->view('tweep_header_menu'); ?>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Followers</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($mention['data'] as $r): ?>
                    <tr class="tr-">
                        <td>
                            <img height="48" width="48" src="<?php echo $r->profile_image_url ?>" alt="<?php echo $r->screen_name; ?>" class="user-profile-link">
                        </td>
                        <td><?php echo $r->created_at; ?></td>
                        <td>
                            <div class="twitter-sender">
                                <strong><?php echo $r->screen_name; ?></strong>
                                (<?php echo $r->name; ?>)</div>
                            <div class="twitter-text"><?php echo $r->tweet_text; ?></div>
                            <div class="twitter-text"><?php echo $r->created_at; ?></div>
                        </td>
                        <td><?php echo $r->followers_count; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <!-- /table -->

        <!-- pagination ends -->
        <div class="pagination right">
            <?php echo $pagination; ?>
        </div>		
        <!-- .pagination ends -->



    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
