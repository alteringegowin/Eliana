<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Keywords</h2>
        <ul>
            <li><a href="<?php echo site_url('tweep/index/' . $tweep->user_id) ?>">Status</a></li>
            <li class="active">WordCloud</li>
            <li><a href="<?php echo site_url('tweep/mention/' . $tweep->user_id) ?>">Mention</a></li>
            <li><a href="<?php echo site_url('tweep/user/' . $tweep->user_id) ?>">User</a></li>
        </ul>
    </div>
    <div class="block_content">

        <form action="<?php echo current_url() ?>" method="post">
            <div style="padding:4px;">
                <div style="float: left;width:280px;">
                    <label>Start:</label>
                    <input type="text" class="text tiny datepicker" name="start" value=""/>
                </div>
                <div style="float: left; width: 280px;">
                    <label>End:</label>
                    <input type="text" class="text tiny datepicker" name="end" value=""/>
                </div>
                <div style="float: left;">
                    <input type="submit" class="submit small" value="View" />
                </div>
                <div style="clear:both;"></div>
            </div>
        </form>

        <hr />
        <div class="ui-widget ui-widget-header ui-corner-top">dadad</div>
        <div class="ui-widget ui-widget-content ui-corner-bottom"><p><?php echo $cloud ?></p></div>



        <!-- table -->
        <table cellpadding="0" cellspacing="0" width="100%" class="">
            <thead>
                <tr>
                    <th>Keyword</th>
                    <th>Count</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($keywords as $r): ?>
                    <tr>
                        <td><?php echo $r['word'] ?></td>
                        <td><?php echo $r['count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
        <!-- /table -->

    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		