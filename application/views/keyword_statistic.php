<table class="stats" rel="line" cellpadding="0" cellspacing="0" width="100%"> 

    <caption>Tweet And User Comparison </caption>
    <thead>
        <tr>
            <td></td>
            <?php foreach ($freq as $r): ?>
                <th scope="col"><?php echo $r->tanggal ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>users</th>
            <?php foreach ($freq as $r): ?>
                <td><?php echo $r->users ?></td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <th>tweets</th>
            <?php foreach ($freq as $r): ?>
                <td><?php echo $r->tweets ?></td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>


