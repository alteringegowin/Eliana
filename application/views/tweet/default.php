<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keyword : <?php echo $keyword_string ?></h2>
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
                    <th width="10"><input type="checkbox" class="check_all"></th>
                    <th>photo</th>
                    <th>Tweet</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tweets['data'] as $r): ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><img src="<?php echo $r->profile_image_url ?>"/></td>
                        <td>
                            <div class="twitter-sender">
                                <strong><?php echo $r->screen_name ?></strong>
                                (<?php echo $r->name ?>)</div>
                            <div class="twitter-text"><?php echo $r->tweet_text ?></div>
                            <div class="twitter-text"><?php echo $r->created_at ?></div>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>

        </table>
        <!-- /table -->
        <div class="tableactions">
            <select>
                <option value="">------</option>
                <option value="p">Positive</option>
                <option value="n">Negative</option>
                <option value="a">Ask</option>
            </select>

            <input type="submit" class="submit tiny" value="Apply to selected">
        </div>
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
