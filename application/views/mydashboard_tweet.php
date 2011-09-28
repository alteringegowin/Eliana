<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords <?php echo $keyword ?></h2>
		<div align="right">
			<a href="<?php echo site_url('mydashboard/statistic/'.$keyword) ?>">Statistic </a>
			<form name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="submit" name="minus" value="Minus">
			<input type="submit" name="netral" value="Netral">
			<input type="submit" name="positif" value="Positif">
		</div>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
			<thead>
                <tr>
					<th>
						<input type="checkbox" name="Check_ctr" value="yes" onClick="Check(document.myform.cid)"> 
                    </th>
					<th>Photo</th>
                    <th>Status</th>
                    <th>Followers</th>
					<th>Sentiment</th>
                </tr>
            </thead>

            <tbody>
                <?php if($tweets): foreach ($tweets as $r): ?>
                    <tr class="tr-">
						<td align="center"><input type="checkbox" name="cid[]" value="<?php echo $r->tweet_id ?>"></td>
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
						<td>
							<?php 
								if($r->sentiment == 'm'){echo 'minus';}
								elseif($r->sentiment == 'n'){echo 'netral';}
								elseif($r->sentiment == 'p'){echo 'positif';}
							?>
						</td>
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

<SCRIPT LANGUAGE="JavaScript">

function Check(chk)
{
if(document.myform.Check_ctr.checked==true){
	select(1);
}else{
	select(0);
}
}

function select(a) {
    var theForm = document.myform;
    for (i=0; i<theForm.elements.length; i++) {
        if (theForm.elements[i].name=='cid[]')
            theForm.elements[i].checked = a;
    }
}

</script>