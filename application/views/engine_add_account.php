<script>
    $(document).ready(function(){
        
        $("#save-to-db").click(function(){
            var url = $(this).attr('href');
            var user_id = $("#txt-user-id").val();
            var screen_name = $("#txt-screen-name").val();
            
            $.post(url,{ user_id: user_id,screen_name:screen_name},function(r){
                if(r == 'false'){
                    alert('Account telah ada');
                }else{
                    window.location.replace("<?php echo site_url('engine')?>");
                }
            });
            return false;
        });
        
    });
    
</script>
<div class="block small small">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Add Account Twitter</h2>
    </div>
    <div class="block_content">
        <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Data</th>
                    <th>Followers</th>
                </tr>
            </thead>
            <tr>
                <td><img src="<?php echo $user->profile_image_url ?>"/></td>
                <td>
                    <strong><?php echo $user->screen_name ?> (<?php echo $user->name ?>)</strong>
                    <div>
                        <?php echo $user->description ?>
                    </div>

                </td>
                <td><?php echo $user->followers_count ?></td>
            </tr>
        </table>
        <div style="text-align: center;">
            <form>
                <input type="hidden" id="txt-screen-name" name="screen_name" value="<?php echo $user->screen_name ?>" />
                <input type="hidden" id="txt-user-id" name="user_id" value="<?php echo $user->id_str ?>" />
                <a href="<?php echo site_url('engine/save/account') ?>" class="buttonUI"  id="save-to-db">Save Account</a>
            </form>
        </div>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
</div>		