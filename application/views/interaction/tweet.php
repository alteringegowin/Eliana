<!-- head -->
<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords : <?php echo $keyword ?></h2>
    </div>

    <!-- block_content ends --> 
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
                </tr>
            </thead>

            <tbody>
                <?php $now = 0; ?>
                <?php foreach ($tweets as $r): ?>

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
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <!-- /table -->
    </div>

    <!-- block_content ends --> 
    <div class="bendl"></div> 
    <div class="bendr"></div> 
</div>
<!-- /head -->
