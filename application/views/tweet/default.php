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

        <form action="<?php echo site_url('tweet/index/' . $keyword_id) ?>" method="post" id="frm-tweep-statistic">
            <div style="padding:4px;">
                <div style="float: left;width:280px;">
                    <label>Start:</label>
                    <input type="text" class="text tiny datepicker" name="start" value="<?php echo $start ?>"/>
                </div>
                <div style="float: left; width: 280px;">
                    <label>End:</label>
                    <input type="text" class="text tiny datepicker" name="end" value="<?php echo $end ?>"/>
                </div>
                <div style="float: left;">
                    <input type="hidden" name="keyword" value="<?php echo $keyword_string ?>" id="input-keyword"/>
                    <input type="submit" class="submit small" name="view" id="btn-keyword-submit" value="View" />
                </div>
                <div style="clear:both;"></div>
            </div>
        </form>
        <script>
            $(".datepicker").datepicker({
                dateFormat:'yy-mm-dd'
            });
        </script>
        <form>
            <!-- table -->
            <table cellpadding="0" cellspacing="0" width="100%" class="">
                <thead>
                    <tr>
                        <th>photo</th>
                        <th>Tweet</th>
                        <th>Followers</th>
                        <th>Sentiment</th>
                        <th style="width:330px;text-align: right;">Sentiment Options</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($tweets['data'] as $r): ?>
                        <tr>
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
                            <td style="width:330px;text-align: right;">
                                <input class="buttonUI" type="button" name="minus" value="negatif" onclick="callAjaxSentiment('<?php echo $r->tweet_id ?>','m');" />
                                <input class="buttonUI" type="button" name="netral" value="netral" onclick="callAjaxSentiment('<?php echo $r->tweet_id ?>','n');" />
                                <input class="buttonUI" type="button" name="positif" value="positif" onclick="callAjaxSentiment('<?php echo $r->tweet_id ?>','p');" />
                                <input class="buttonUI" type="button" name="ask" value="ask" onclick="callAjaxSentiment('<?php echo $r->tweet_id ?>','a');" />
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>

            </table>
            <!-- /table -->
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