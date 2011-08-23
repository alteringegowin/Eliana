<div class="block small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Account Twitter</h2>
    </div>
    <div class="block_content">
        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>User</th>
                    <th>Total Followers</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($acc as $r): ?>
                    <tr>
                        <td><span style="font-size: 1.4em;"><?php echo $i++; ?></span></td>
                        <td><img src="<?php echo $r->profile_image_url ?>"/></td>
                        <td>
                            <h4><a href="<?php echo site_url('tweep/index/' . $r->user_id) ?>"><?php echo $r->screen_name ?></a> </h4>
                            <small><?php echo $r->description ?></small>
                        </td>
                        <td><?php echo $r->followers_count ?></td>
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

<div class="block small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Keyword</h2>
    </div>
    <div class="block_content">
        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Keywords</th>
                    <th>Date</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($keywords as $r): ?>
                    <tr>
                        <td><?php echo anchor('keyword/archieve/'.$r->id.'/',$r->keyword) ?></td>
                        <td><?php echo  unix_to_human($r->keyword_date) ?></td>
                        <td>&nbsp;</td>
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