<h2>Growth Graph</h2>
<table class="stats" rel="line" cellpadding="0" cellspacing="0" width="100%"> 
    
    <caption>Followers Growth</caption>
    <thead>
        <tr>
            <td></td>
            <?php foreach ($growth as $r): ?>
            <th scope="col"><?php echo get_bulan(substr($r->tgl , 5,2))?> <?php echo substr($r->tgl , 8,2)?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>users</th>
            <?php foreach ($growth as $r): ?>
                <td><?php echo $r->followers ?></td>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>


