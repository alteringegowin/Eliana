<div class="block left small">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Download: <?php echo $tweep->screen_name ?></h2>
        <?php $this->load->view('tweep/tweep_header_menu'); ?>
    </div>
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>

        <form id="frm-account-add" action="<?php echo current_url() ?>" method="post">
            <p><label>Select label:</label> <br/>
                <select class="styled" name="mode"> 
                    <option value="tweet"><?php echo $tweep->screen_name ?> Tweets</option> 
                    <option value="mention"><?php echo $tweep->screen_name ?> Mentions</option> 
                </select>
            </p> 
            <p>
                <label>Starting date:</label>  <br/>
                <input type="text" class="text date_picker " name="start"/>
            </p>
            <p>
                <label>Ending date:</label>  <br/>
                <input type="text" class="text date_picker "  name="end"/>
            </p>
            <p>
                <label style="width:200px;display:block;">&nbsp;</label> 
                <input type="submit" class="submit mid" value="Download" />
            </p>
        </form>


    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
<script type="text/javascript">
    $(function () {
        $(".date_picker").datepicker({
            dateFormat:'yy-mm-dd'
        });
    });
</script>