<!-- table -->
<h3>Data Tweets Dam Jumlah Follower</h3>
<table cellpadding="0" cellspacing="0" width="100%" class="ui-widget">
    <thead class=" ui-widget-header">
        <tr>
            <th>#</th>
            <th>Most Tweets</th>
            <th>Most Followers</th>
        </tr>
    </thead>

    <tbody class=" ui-widget-content">
        <?php $no = 1; ?>
        <?php foreach ($data as $r): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td>
                    <strong><?php echo $r['t_screen_name'] ?> </strong>
                    <small>(<?php echo $r['t_counted'] ?> tweets)</small>
                </td>
                <td>
                    <strong><?php echo $r['f_screen_name'] ?> </strong>
                    <small>(<?php echo $r['f_counted'] ?> followers)</small>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
