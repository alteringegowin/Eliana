<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Last Status: <?php echo $tweep->screen_name ?></h2>
        <?php $this->load->view('tweep/tweep_header_menu'); ?>
    </div>
    <div class="block_content">
        
        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>
        
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th>photo</th>
                    <th>Created at</th>
                    <th>Status</th>
                    <th>Followers</th>
                    <th>Growth Efek</th>
                    <th>RT Count</th>
                    <th>Reply Count</th>
                </tr>
            </thead>

            <tbody>
                <?php $now = 0; ?>
                <?php foreach ($acc['data'] as $r): ?>
                    <?php
                    $count_reply = count_reply($r->tweet_id);
                    if ( $now ):
                        $selisih = $now - $r->followers_count;
                        $now = $r->followers_count;
                    else:
                        $now = $r->followers_count;
                        $selisih = 0;
                    endif;
                    ?>

                    <tr class="tr-">
                        <td>
                            <img height="48" width="48" src="<?php echo $r->profile_image_url ?>" alt="<?php echo $r->profile_image_url ?>" class="user-profile-link">
                        </td>
                        <td><?php echo $r->created_at ?></td>
                        <td>
                            <div class="twitter-sender">
                                <strong><?php echo $r->screen_name ?></strong>
                                (<?php echo $r->name ?>)</div>
                            <div class="twitter-text"><?php echo $r->tweet_text ?></div>
                            <div class="twitter-text"><?php echo $r->created_at ?></div>
                        </td>
                        <td><?php echo $r->followers_count ?></td>
                        <td><?php echo $selisih < 0 ? $selisih : '+' . $selisih ?></td>
                        <td>
                            <?php $cRT = count_retweeted($r->tweet_text, $r->screen_name, $r->user_id,$r->created_at) ?>
                            <?php //$cRT = 0;?>
                            <?php if ( $cRT ): ?>
                                <a href="<?php echo site_url('tweep/rt/' . $tweep->user_id . '/' . $r->tweet_id) ?>"><?php echo $cRT ?></a>
                            <?php else: ?>
                                0
                            <?php endif; ?>
                        </td>
                        <td><a href="<?php echo site_url('tweep/reply/' . $tweep->user_id . '/' . $r->tweet_id) ?>"><?php echo $count_reply ? $count_reply->total : 0 ?></a></td>
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
