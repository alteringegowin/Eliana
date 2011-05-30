



<div class="block"> 

    <div class="block_head"> 
        <div class="bheadl"></div> 
        <div class="bheadr"></div> 

        <h2>Stats of : "<?php echo $keyword->keyword ?>"</h2> 

        <ul> 
            <li><a href="<?php echo site_url('keyword/cloud/'.$keyword_id) ?>">Most Accounts</a></li> 
            <li><a href="<?php echo site_url('keyword/cloud/'.$keyword_id) ?>">Cloud</a></li> 
            <li><a href="<?php echo site_url('keyword/statistic/'.$keyword_id) ?>">Graphic</a></li> 
        </ul> 
    </div>		<!-- .block_head ends --> 



    <div class="block_content " id="days"> 

        <table class="stats" rel="line" cellpadding="0" cellspacing="0" width="100%">
            <caption>Penyebaran Tweet/Waktu</caption>
            <thead>
                <tr>
                    <td>&nbsp;</td>
                    <?php foreach ($stats['tanggal'] as $r): ?>
                        <th scope="col"><?php echo $r ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <th>Tweets</th>
                    <?php foreach ($stats['tweet'] as $r): ?>
                        <td><?php echo $r ?></td>
                    <?php endforeach; ?>
                </tr>

                <tr>
                    <th>Accounts</th>	
                    <?php foreach ($stats['acc'] as $r): ?>
                        <td><?php echo $r ?></td>
                    <?php endforeach; ?>
                    <td>40</td>
                </tr>

            </tbody>
        </table>


    </div>		<!-- .block_content ends --> 





    <div class="bendl"></div> 
    <div class="bendr"></div> 
</div>		<!-- .block ends -->