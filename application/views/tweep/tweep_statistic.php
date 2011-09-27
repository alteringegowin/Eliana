<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Last Status: <?php echo $tweep->screen_name ?></h2>
        <?php $this->load->view('tweep/tweep_header_menu'); ?>
    </div>
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>

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
        <div id="statistic">
            <div id="tweep-mention" class="reg ui-widget"></div>
            <div id="tweep-growth" class="reg"></div>
            <div id="tweep-num" class="reg ui-widget"></div>
            <div id="tweep-stat"  class="reg"></div>
            <div id="tweep-cloud"  class="reg"></div>
        </div>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		