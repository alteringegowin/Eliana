<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Keywords</h2>

        <ul>
            <li><a href="#">Add Keyword</a></li>

        </ul>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>Keywords</th>
                    <th>Status</th>
                    <td>&nbsp;</td>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($keywords['data'] as $r): ?>
                    <tr>
                        <td><a href="<?php echo site_url('keyword/archieve/' . $r->id) ?>"><?php echo $r->keyword ?></a></td>
                        <td><?php echo $r->keyword_date ?></td>
                        <td class="delete"><a href="#">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
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