<!-- head -->
<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords : <?php echo $keyword ?></h2>
    </div>

    <!-- block_content ends --> 
    <div class="block_content">

        <?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>

        <div class="demo">
            <form action="<?php echo site_url('interaction/periode') ?>" method="post">
                <label for="from">From</label>
                <input type="text" id="from" name="from" value="<?php echo $start ?>" class="textdate" />
                <label for="to">to</label>
                <input type="text" id="to" name="to"  value="<?php echo $end ?>"  class="textdate" />
                <input type="hidden" name="keyword_id" value="<?php echo $keyword_id ?>"/>
                <input type="submit" value="Set Periode" class="buttonUI" />
            </form>
        </div>
        <div id="statistic" class="ui-widget">
            <div class="statistic-num" style="width: 90px;">

                <a href="<?php echo site_url('interaction/download/'. $keyword_id . '/' . $start . '/' . $end )?>" class="buttonUI">Download Data</a>
            </div>
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all" style="width: 90px;">
                <div>Total Tweet</div>
                <div class="number"><?php echo number_format($total['tweets']) ?></div>
            </div>
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all " style="width: 90px;">
                <div>Total User</div>
                <div class="number"><?php echo number_format($total['users']) ?></div>
            </div>
            <div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all" style="width: 120px;">
                <div>Total Impression</div>
                <div class="number"><?php echo number_format($total['impression']) ?></div>
            </div>
			<div class="statistic-num" style="width: 90px;">

                <a href="<?php echo site_url('interaction/sentimentstat/'. $keyword_id . '/' . $start . '/' . $end )?>" class="buttonUI">Sentiment</a>
            </div>
            <div class="clear"></div>


        </div>
    </div>

    <!-- block_content ends --> 
    <div class="bendl"></div> 
    <div class="bendr"></div> 
</div>
<!-- /head -->

<div class="block  small left">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Data Interaksi</h2>
    </div>

    <!-- block_content ends --> 
    <div class="block_content">

        <!-- End demo -->

        <table id="sort-col2" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th style="text-align: right;">Jumlah Users</th>
                    <th style="text-align: right;">Tweets</th>
                    <th style="text-align: right;">Impressions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($interactions as $r): ?>

                    <tr>
                        <td><?php echo anchor('interaction/tweet/' . $keyword_id . '/' . $start . '/' . $end . '/' . $r->tanggal, $r->tanggal) ?></td>
                        <td style="text-align: right;"><?php echo number_format($r->users) ?></td>
                        <td style="text-align: right;"><?php echo number_format($r->tweets) ?></td>
                        <td style="text-align: right;"><strong><?php echo number_format($r->impression) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>		
    <!-- .block_content ends --> 

    <div class="bendl"></div> 
    <div class="bendr"></div> 

</div>


<div class="block  small right">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>User Statistik</h2>
    </div>

    <!-- block_content ends --> 
    <div class="block_content">

        <!-- End demo -->

        <table id="sort-col3" cellpadding="0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Jumlah Tweet</th>
                    <th>&nbsp;</th>
                    <th>User </th>
                    <th>Jumlah Follower</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($users as $r): ?>

                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo anchor('interaction/user/' . $keyword_id . '/' . $r['t_user_id'] . '/' . $start . '/' . $end, $r['t_screen_name']) ?></td>
                        <td><?php echo $r['t_counted'] ?></td>
                        <td>&nbsp;</td>
                        <td><?php echo anchor('interaction/user/' . $keyword_id . '/' . $r['f_user_id'] . '/' . $start . '/' . $end, $r['f_screen_name']) ?></td>
                        <td><?php echo $r['f_counted'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>		
    <!-- .block_content ends --> 

    <div class="bendl"></div> 
    <div class="bendr"></div> 

</div>