<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Account</h2>
    </div>

    <!-- block_content ends --> 
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>

        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th style="text-align: right">Impression For last 7 days</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($acc as $r): ?>
                    <tr>
                        <td><span style="font-size: 1.4em;"><?php echo $i++; ?></span></td>
                        <td>
                            <h4><a href="<?php echo site_url('tweep/index/' . $r->user_id) ?>"><?php echo $r->screen_name ?></a> </h4>
                        </td>
                        <td style="text-align: right"><?php echo number_format($r->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>		
    <!-- .block_content ends --> 

    <div class="bendl"></div> 
    <div class="bendr"></div> 

</div>
