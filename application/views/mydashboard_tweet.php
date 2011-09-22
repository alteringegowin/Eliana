<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords</h2>
		<div>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="submit" name="positif" value="Positif">
			<input type="submit" name="minus" value="Minus">
			<input type="submit" name="netral" value="Netral">
		</div>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
			<thead>
                <tr>
                    <th>photo</th>
                    <th>Status</th>
                    <th>Followers</th>
					<th>Sentiment</th>
					<th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if($tweets): foreach ($tweets as $r): ?>
                    <tr class="tr-">
                        <td>
                            <img height="48" width="48" src="<?php echo $r->profile_image_url ?>" alt="<?php echo $r->profile_image_url ?>" class="user-profile-link">
                        </td>
                        <td>
                            <div class="twitter-sender">
                                <strong><?php echo $r->screen_name ?></strong>
                                (<?php echo $r->name ?>)</div>
                            <div class="twitter-text"><?php echo $r->tweet_text ?></div>
                            <div class="twitter-text"><?php echo $r->created_at ?></div>
                        </td>
                        <td><?php echo $r->followers_count ?></td>
						<td align="center"><?php echo $r->sentiment ?></td>
						<td align="center"><input type="checkbox" name="cid[]" value="<?php echo $r->tweet_id ?>"></td>
                    </tr>
                <?php endforeach; endif;?>
            </tbody>
		</form>
        </table>
        <!-- /table -->
	<div class="pagination right">
           <?php echo $pagination; ?>
    </div>

    </div>		
    <!-- .block_content ends --> 

    <div class="bendl"></div> 
    <div class="bendr"></div> 

</div>