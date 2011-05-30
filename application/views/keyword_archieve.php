<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Keywords</h2>
        <ul>
            <li><a href="<?php echo site_url('keyword/export/'.$this->uri->segment(3,0)) ?>">Exports</a></li>
            <li><a href="<?php echo site_url('keyword/statistic/'.$this->uri->segment(3,0)) ?>">Statistic</a></li>
        </ul>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>photo</th>
                    <th>Status</th>
                    <th>Followers</th>
                    <th>Sentiment</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($searchs['data'] as $r): ?>
                    <tr class="tr-<?php echo $r->sentiment?>">
                        <td>
                            <img height="48" width="48" src="<?php echo $r->profile_image_url ?>" 
                                 alt="<?php echo $r->screen_name ?>" 
                                 class="user-profile-link" 
                                 />
                        </td>
                        <td>
                            <div class="twitter-sender">
                                <strong><?php echo $r->screen_name ?></strong>
                                (<?php echo $r->name ?>)</div>
                            <div class="twitter-text"><?php echo $r->tweet_text ?></div>
                            <div class="twitter-text"><?php echo $r->created_at ?></div>
                            <div class="twitter-text">
                                <span class=""><?php echo sentiment($r->sentiment) ?></span>
                            </div>
                        </td>
                        <td><?php echo $r->followers_count ?></td>
                        <td class="delete">
                            <a href="<?php echo site_url('keyword/mark_sentiment/' . $r->tweet_id . '/p') ?>" class="sentiment sentiment-positif">mark this tweet as positive</a>
                            <a href="<?php echo site_url('keyword/mark_sentiment/' . $r->tweet_id . '/m') ?>" class="sentiment sentiment-negatif">mark this tweet as negative</a>
                            <a href="<?php echo site_url('keyword/mark_sentiment/' . $r->tweet_id . '/a') ?>" class="sentiment sentiment-ask">mark this tweet as asking</a>
                            <a href="<?php echo site_url('keyword/mark_sentiment/' . $r->tweet_id . '/n') ?>" class="sentiment sentiment-netral">mark this tweet as neutral</a>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>

        </table>
        <!-- /table -->

        <!-- pagination ends -->
        <div class="pagination right">
            <?php echo $pagination ?>
        </div>		
        <!-- .pagination ends -->



    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
