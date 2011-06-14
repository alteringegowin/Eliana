<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2><?php echo $tweep->screen_name ?></h2>
        <ul>
            <li><a href="<?php echo site_url('tweep/index/' . $tweep->user_id) ?>">Status</a></li>
            <li class="active">WordCloud</li>
            <li><a href="<?php echo site_url('tweep/mention/' . $tweep->user_id) ?>">Mention</a></li>
            <li><a href="<?php echo site_url('tweep/user/' . $tweep->user_id) ?>">User</a></li>
        </ul>
    </div>
    <div class="block_content">

        <form action="<?php echo current_url() ?>" method="post" id="frm-tweep-statistic">
            <div style="padding:4px;">
                <div style="float: left;width:280px;">
                    <label>Start:</label>
                    <input type="text" class="text tiny datepicker" name="start" value=""/>
                </div>
                <div style="float: left; width: 280px;">
                    <label>End:</label>
                    <input type="text" class="text tiny datepicker" name="end" value=""/>
                </div>
                <div style="float: left;">
                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>" id="input-user-id"/>
                    <input type="submit" class="submit small" id="btn-keyword-submit" value="View" />
                </div>
                <div style="clear:both;"></div>
            </div>
        </form>
        <p>&nbsp;</p>

        <div id="tweep-growth" class="reg"></div>
        <div id="tweep-stat"  class="reg"></div>
        <div id="tweep-cloud"  class="reg"></div>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		