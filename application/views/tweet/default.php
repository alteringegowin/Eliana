<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keyword : <?php echo $keyword_string ?></h2>
        <ul>
            <li><?php echo anchor('tweet/index/' . $keyword_id, 'All') ?></li>
            <li><?php echo anchor('tweet/sentiment/' . $keyword_id . '/p/', 'Positive') ?></li>
            <li><?php echo anchor('tweet/sentiment/' . $keyword_id . '/m/', 'Negative') ?></li>
            <li><?php echo anchor('tweet/sentiment/' . $keyword_id . '/n/', 'Netral') ?></li>
            <li><?php echo anchor('tweet/sentiment/' . $keyword_id . '/a/', 'Ask') ?></li>
        </ul>
    </div>
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>
        
        
        <form action="<?php echo site_url('tweet/post_sentiment') ?>" method="post">
            <!-- table -->
            <table cellpadding="0" cellspacing="0" width="100%" class="">
                <thead>
                    <tr>
                        <th width="10"><input type="checkbox" class="check_all"></th>
                        <th>photo</th>
                        <th>Tweet</th>
                        <th>Followers</th>
                        <th>Sentiment</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($tweets['data'] as $r): ?>
                        <tr>
                            <td><input type="checkbox" name="user_id[]" value="<?php echo $r->tweet_id ?>"></td>
                            <td><img src="<?php echo $r->profile_image_url ?>"/></td>
                            <td>
                                <div class="twitter-sender">
                                    <strong><?php echo $r->screen_name ?></strong>
                                    (<?php echo $r->name ?>)</div>
                                <div class="twitter-text"><?php echo $r->tweet_text ?></div>
                                <div class="twitter-text"><?php echo $r->created_at ?></div>
                            </td>
                            <td><?php echo $r->followers_count ?></td>
                            <td><span class="sentiment-<?php echo $r->sentiment ?>"><?php echo sentiment($r->sentiment) ?></span></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
            <!-- /table -->
            <div class="tableactions">
                <select name="sentiment">
                    <option value="">------</option>
                    <option value="p">Positive</option>
                    <option value="m">Negative</option>
                    <option value="n">Netral</option>
                    <option value="a">Ask</option>
                </select>

                <input type="submit" class="submit tiny" value="Apply to selected">
            </div>

        </form>
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
