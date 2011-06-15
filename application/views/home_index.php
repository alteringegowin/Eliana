<script>
    $(document).ready(function(){
        $("#s_q").click(function(){
            $(this).val('');
        }).blur(function(){
            if($(this).val() == ''){
                $(this).val('Search');
            }else{
                $("#frm-search").submit();
            }
        });
    });
</script>
<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Pages</h2>
        <form action="<?php echo site_url('home/search') ?>" method="post" id="frm-search">
            <input type="text" class="text" name="q" id="s_q" value="Search" />
        </form>
    </div>
    <div class="block_content">
        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Data</th>
                    <th>Followers</th>
                    <th>Last Update</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($followeds['data'] as $r): ?>
                    <?php if ( $r->description ): ?>
                        <tr>
                            <td><img src="<?php echo $r->profile_image_url ?>"/></td>
                            <td>
                                <strong><a href="<?php echo site_url('tweep/index/' . $r->user_id) ?>"><?php echo $r->screen_name ?> (<?php echo $r->name ?>)</a></strong>
                                <div>
                                    <?php echo $r->description ?>
                                </div>

                            </td>
                            <td><?php echo $r->followers_count ?></td>
                            <td><?php echo date('Y-m-d H:i', mysql_to_unix($r->last_update)) ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td>not available yet</td>
                            <td>
                                <strong><?php echo $r->screen_name ?> </strong>
                            </td>
                            <td>not available yet</td>
                            <td>not available yet</td>
                        </tr>
                    <?php endif; ?>
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
<!-- .login ends -->
