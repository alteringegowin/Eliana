<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>User : <?php echo $tweep->screen_name ?></h2>
        <?php $this->load->view('tweep_header_menu'); ?>
    </div>
    <div class="block_content">
        <h3>Top 10 User Mention</h3>
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th style="width:50px;">&nbsp;</th>
                    <th>User Mention</th>
                    <th style="width: 150px;text-align: right">Followers</th>
                    <th style="width: 150px;text-align: right">Total Mention</th>
                    <th style="width:50px;border-right: solid 1px #363636">&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>User Mentioned</th>
                    <th style="width: 150px;text-align: right">Followers</th>
                    <th style="width: 150px;text-align: right">Total Mentioned</th>
                </tr>
            </thead>

            <tbody>
                <?php for ($i = 0; $i < 10; $i++): ?>
                    <?php $mention = isset($mentions[$i]) ? $mentions[$i] : array(); ?>
                    <?php $mentioned = isset($mentioneds[$i]) ? $mentioneds[$i] : array(); ?>
                    <tr>
                        <?php if ( $mention ): ?>
                            <td><img src="<?php echo $mention->profile_image_url ?>" alt="<?php echo $mention->screen_name ?>"/></td>
                            <td>
                                <h4><?php echo $mention->screen_name ?></h4>
                                <small><?php echo $mention->description ?></small>
                            </td>
                            <td style="text-align: right;"><?php echo number_format($mention->followers_count) ?></td>
                            <td style="text-align: right;"><?php echo number_format($mention->total) ?></td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        <?php endif; ?>

                        <td style="border-right: solid 1px #363636">&nbsp;</td>
                        <?php if ( $mentioned ): ?>
                            <td><img src="<?php echo $mentioned->profile_image_url ?>" alt="<?php echo $mentioned->screen_name ?>"/></td>
                            <td>
                                <h4><?php echo $mentioned->screen_name ?></h4>
                                <small><?php echo $mentioned->description ?></small>
                            </td>
                            <td style="text-align: right;"><?php echo number_format($mentioned->followers_count) ?></td>
                            <td style="text-align: right;"><?php echo number_format($mentioned->total) ?></td>
                        <?php else: ?>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        <?php endif; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>

        </table>
        <!-- /table -->

        <p>&nbsp;</p>



    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
