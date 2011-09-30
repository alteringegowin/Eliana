<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keyword : <?php echo $keyword_string ?></h2>
    </div>
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>

        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th>#</th>
                    <th>photo</th>
                    <th>Tweet</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($tweets['data'] as $r): ?>
                <td><?php ++$no; ?></td>
                <td><img src="<?php echo $r->profile_image_url?>"/></td>
                <td><img src="<?php echo $r->profile_image_url?>"/></td>
            <?php endforeach; ?>

            </tbody>

        </table>
        <!-- /table -->

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
