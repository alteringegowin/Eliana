<!-- head -->
<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords : <?php echo $keyword ?></h2>
        <form action="" method="post">
            <input type="text" class="text" value="Search">
        </form>
    </div>

    <!-- block_content ends --> 
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>


        <!-- table -->
        <form action="" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="">
                <thead>
                    <tr>
                        <th width="10"><input type="checkbox" class="check_all"></th>
                        <th>photo</th>
                        <th>Screen Name (nama)</th>
                        <th>Sex</th>
                        <th>Location</th>
                        <th>Followers</th>
                        <th>Friends</th>
                        <th>Status Count</th>
                        <th>Timezone</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $r): ?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <img height="48" width="48" src="<?php echo $r->profile_image_url ?>" alt="<?php echo $r->profile_image_url ?>" class="user-profile-link">
                            </td>
                            <td>
                                <div class="twitter-sender">
                                    <strong><?php echo $r->screen_name ?></strong>
                                    (<?php echo $r->name ?>)</div>
                                <div class="twitter-text"><?php echo $r->description ?></div>
                                <div class="twitter-text"><?php echo $r->created_at ?></div>
                            </td>
                            <td><?php echo $r->sex ?></td>
                            <td><?php echo $r->location ?></td>
                            <td><?php echo $r->followers_count ?></td>
                            <td><?php echo $r->friends_count ?></td>
                            <td><?php echo $r->statuses_count ?></td>
                            <td><?php echo $r->time_zone ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
            <!-- /table -->

            <div class="tableactions">
                <select>
                    <option>------</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                    <option value="b">Brand</option>
                </select>

                <input type="submit" class="submit tiny" value="Apply to selected">
            </div>
        </form>
        <div class="pagination right">
            <?php echo $pagination; ?>
        </div>
    </div>

    <!-- block_content ends --> 
    <div class="bendl"></div> 
    <div class="bendr"></div> 
</div>
<!-- /head -->
