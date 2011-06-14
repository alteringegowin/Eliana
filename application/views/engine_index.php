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