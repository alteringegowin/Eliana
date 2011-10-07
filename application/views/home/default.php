<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Dashboard</h2>
        <ul>
            <li>Profile</li>
            <li>Change Password</li>
        </ul>
    </div>
    <div class="block_content">
        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>log_date</th>
                    <th>Keterangan</th>
                    <th>Entitas</th>
                </tr>
            </thead>


            <tbody>
                <?php foreach ($logs as $r): ?>
                    <tr>
                        <td><?php echo $r->log_date ?></td>
                        <td><?php echo $r->action ?></td>
                        <td><?php echo $r->tweet_id ? $r->tweet_id : ''; ?></td>
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
