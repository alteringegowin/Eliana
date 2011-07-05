<script>
    $(document).ready(function(){
        
        $("#button-engine-stop").click(function(){
            var url = $(this).attr('href');
            $.get(url,function(r){
                window.location.reload();
            });
            return false;
        });
        $("#button-engine-start").click(function(){
            var url = $(this).attr('href');
            $.get(url,function(r){
                window.location.reload();
            });
            return false;
        });
        
        $("#button-add-keyword").click(function(){
            var url = $(this).attr('href');
            var data = $("#txt-add-keyword").val();
            $.post(url,{ keyword: data},function(r){
                if(r == 'false'){
                    alert('Keyword telah ada');
                }else{
                    alert('Keyword sukses ditambahkan, jangan lupa untuk me restart engine');
                }
            });
            return false;
        });
        
    });
    
</script>

<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Engine</h2>
    </div>
    <div class="block_content">
        <?php if ( $process ): ?>
            <h2>Elliana Engine: RUNNING</h2>
            <p>
                Please do not over react with this button. Please just start/stop engine with one minutes interval in between
            </p>
            <p><a href="<?php echo $url_stop ?>" class="buttonUI" id="button-engine-stop">Stop Engine</a></p>
        <?php else: ?>

            <h2>Elliana Engine: NOT RUNNING</h2>
            <p>
                Please do not over react with this button. Please just start/stop engine with one minutes interval in between
            </p>
            <p>
                <a href="<?php echo $url_start ?>" class="buttonUI"  id="button-engine-start">Start Engine</a>
            </p>
        <?php endif; ?>

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
</div>		
<!-- .login ends -->



<div class="block small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Add Keywords</h2>
    </div>
    <div class="block_content">
        <p>
            You can add <strong>dada</strong> keywords left
        </p>
        <form id="frm-account-add" action="#" method="post">
            <p>
                <label>Keyword:</label><br />
                <input type="text" class="text medium" name="keyword" value="" id="txt-add-keyword" style="width:220px"/>
            </p>

            <p>
                <a href="<?php echo site_url('engine/save/keyword') ?>" class="buttonUI"  id="button-add-keyword">Save Keyword</a>
            </p>
        </form>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
</div>		

<div class="block small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Add Account Twitter</h2>
    </div>
    <div class="block_content">
        <p>
            You can add <strong>dada</strong> keywords left
        </p>
        <form id="frm-account-add" action="<?php echo site_url('engine/add_account') ?>" method="post">
            <p>
                <label>Tweet Account:</label><br />
                <input type="text" class="text medium" name="account" value="" id="txt-add-account" style="width:220px"/>
            </p>

            <p>
                <input type="submit" name="save" value="save" class="buttonUI" />
            </p>
        </form>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
</div>		