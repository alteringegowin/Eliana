<script>
    $(document).ready(function(){
        $("#sort-col2").tablesorter( {
            sortList: [[3,1]]
        }); 
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
        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>User</th>
                    <th>Total Mentioned</th>
                    <th>Total Followers</th>
                    <th>Total User</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($stats as $r): ?>
                    <tr>
                        <td><span style="font-size: 1.4em;"><?php echo $i++; ?></span></td>
                        <td><img src="<?php echo $r->profile_image_url ?>"/></td>
                        <td>
                            <h4><?php echo $r->screen_name ?> </h4>
                            <small><?php echo $r->description ?></small>
                        </td>
                        <td><?php echo $r->mentions ?></td>
                        <td><?php echo $r->followers_count ?></td>
                        <td><?php echo $r->users ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
<!-- .login ends -->
