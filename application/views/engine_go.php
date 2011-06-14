<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Account</h2>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Followers</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($calon as $r): ?>
                    <tr>
                        <td>
                            <strong><a target="_blank" href="http://twitter.com/<?php echo $r->screen_name ?>"><?php echo $r->screen_name ?></a> </strong>
                        </td>
                        <td><?php echo $r->followers_count ?> </td>
                        <td>
                            <?php if ( in_array($r->user_id, $ada) ): ?>
                                ada
                            <?php else: ?>
                                <a href="<?php echo site_url('engine/add/'.$r->user_id)?>" class="buttonUI">tambahkan</a>
                            <?php endif; ?>
                        </td>
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
<!-- .login ends -->
