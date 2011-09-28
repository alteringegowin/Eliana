<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords <?php echo $keyword ?> Statistic</h2>
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
                    <input type="hidden" name="keyword" value="<?php echo $keyword ?>"/>
                    <input type="submit" class="submit small" name="view" value="View" />
                </div>
                <div style="clear:both;"></div>
            </div>
        </form>
        <p>&nbsp;</p>
        
		<div id="statistic">
            <table cellpadding="0" cellspacing="0" width="100%" class="">
				<?php if($stats): ?>
				<thead>
				    <tr>
						<th>Tanggal</th>
				        <th>Total Sentiment Minus</th>
				        <th>Total Sentiment Netral</th>
						<th>Total Sentiment Positif</th>
				    </tr>
				</thead>

			    <tbody>
			        <?php 
						$rowbefore=''; for($i=0; $i<count($stats); $i++): 
							if($i>0){
								$rowbefore = $stats[$i-1]->tanggal;
							}
							if($stats[$i]->tanggal !== $rowbefore):
					?>
			            <tr class="tr-">
							<td align="center"><?php echo $stats[$i]->tanggal ?></td>
			                <td>
								<?php 
									if($stats[$i]->sentiment == 'm'){
										echo $stats[$i]->jumlah;
									}elseif($i+1<count($stats) && $stats[$i]->tanggal == $stats[$i+1]->tanggal && $stats[$i+1]->sentiment == 'm'){
										echo $stats[$i+1]->jumlah;
									}elseif($i+2<count($stats) && $stats[$i]->tanggal == $stats[$i+2]->tanggal && $stats[$i+2]->sentiment == 'm'){
										echo $stats[$i+2]->jumlah;
									}else{
										echo '0';
									} 
								?>
							</td>
			                <td>
								<?php 
									if($stats[$i]->sentiment == 'n'){
										echo $stats[$i]->jumlah;
									}elseif($i+1<count($stats) && $stats[$i]->tanggal == $stats[$i+1]->tanggal && $stats[$i+1]->sentiment == 'n'){
										echo $stats[$i+1]->jumlah;
									}elseif($i+2<count($stats) && $stats[$i]->tanggal == $stats[$i+2]->tanggal && $stats[$i+2]->sentiment == 'n'){
										echo $stats[$i+2]->jumlah;
									}else{
										echo '0';
									} 
								?>
							</td>
							<td>
								<?php 
									if($stats[$i]->sentiment == 'p'){
										echo $stats[$i]->jumlah;
									}elseif($i+1<count($stats) && $stats[$i]->tanggal == $stats[$i+1]->tanggal && $stats[$i+1]->sentiment == 'p'){
										echo $stats[$i+1]->jumlah;
									}elseif($i+2<count($stats) && $stats[$i]->tanggal == $stats[$i+2]->tanggal && $stats[$i+2]->sentiment == 'p'){
										echo $stats[$i+2]->jumlah;
									}else{
										echo '0';
									} 
								?>
							</td>
			            </tr>
			        <?php endif; endfor; ?>
			    </tbody>
				<?php endif; ?>
			</table>
        </div>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>