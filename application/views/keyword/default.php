<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords</h2>
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
                    <th>Keywords</th>
                    <th>Date</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($keywords as $r): ?>
                    <tr>
                        <td><?php echo anchor('interaction/index/' . $r->id , $r->keyword) ?></td>
                        <td><?php echo unix_to_human($r->keyword_date) ?></td>
                        <td><?php echo anchor("interaction/index/" . $r->id, 'Interaction Data', 'class="buttonUI"') ?></td>
                        <td>&nbsp;</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>		
    <!-- .block_content ends --> 

    <div class="bendl"></div> 
    <div class="bendr"></div> 

</div>
