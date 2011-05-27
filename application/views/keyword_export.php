	

<div class="block left small">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Keyword: "<?php echo $keyword->keyword?>"</h2>

        <ul>
            <li><a href="<?php echo site_url('keyword/archieve') ?>">Back</a></li>

        </ul>
    </div>
    <div class="block_content">
        <form action="<?php echo current_url() ?>" method="post">
            <p>
                <label>From:</label><br>
                <input type="text" class="text tiny datepicker" name="start" value="">
            </p>
            <p>
                <label>Until:</label><br>
                <input type="text" class="text tiny datepicker" name="end" value="">
            </p>


            <hr>

            <p>
                <input type="submit" class="submit mid" value="Download">
            </p>
        </form>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		

<div class="block right small">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Help</h2>
    </div>
    <div class="block_content">
        <p>
            Content of help
        </p>

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		
