<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords <?php echo $keyword ?> Statistic</h2>
		<?php $this->load->view('mydashboard/header_sentiment'); ?>
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
					<input type="hidden" name="keyword" value="<?php echo $keyword ?>" id="input-keyword"/>
                    <input type="submit" class="submit small" name="view" id="btn-keyword-submit" value="View" />
                </div>
                <div style="clear:both;"></div>
            </div>
        </form>
        
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