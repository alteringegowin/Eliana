
<h2>Statistic</h2>
<!-- table -->
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th style="text-align: right">Re-Tweet</th>
            <th style="text-align: right">Re-Tweeted Users</th>
            <th style="text-align: right">Impression</th>
            <th style="width: 25%;">&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($rt as $r): ?>
            <tr>
                <td><?php echo $r->tanggal ?></td>
                <td style="text-align: right"><?php echo $r->tweet ?> status</td>
                <td style="text-align: right"><?php echo $r->users ?> </td>
                <td style="text-align: right"><?php echo $r->followers ?></td>
                <td style="text-align: right">&nbsp;</td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
<!-- /table -->

<small class="">
    Impression dihitung dari total follower yang meng RT sebuah status. 
    Total Impression belum ditambahkan follower account yang bersangkutan
</small>

