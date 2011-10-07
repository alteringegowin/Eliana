<div class="block">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>
        <h2>Keywords : <?php echo $keyword ?></h2>
    </div>
    <div class="block_content">

		<?php if ( isset($breadcrumbs) ): ?>
            <div class="breadcrumb">
                <?php echo implode("&nbsp;&nbsp; &gt;&nbsp;&nbsp;", $breadcrumbs); ?>
            </div>
        <?php endif; ?>

<h2>Sentiment Data</h2>
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
<br/>

<h2>Sentiment Graph</h2>
            <table class="stats" rel="bar" cellpadding="0" cellspacing="0" width="100%"> 
				<?php if($stats): ?>
			    <thead>
					<tr>
			        <?php 
						$rowbefore=''; 
						for($i=0; $i<count($stats); $i++): 
							if($i>0){
								$rowbefore = $stats[$i-1]->tanggal;
							}
							if($stats[$i]->tanggal !== $rowbefore){					
								echo '<th scope="col" >'.substr($stats[$i]->tanggal , 8,2).'</th>';
							}
						endfor; 
					?>
					</tr>
			    </thead>
				<tbody>
					<tr class="tr-" scope="row">
						<th scope="row">Minus</th>
					<?php 
						$rowbefore=''; 
						for($i=0; $i<count($stats); $i++): 
							if($i>0){
								$rowbefore = $stats[$i-1]->tanggal;
							}
							if($stats[$i]->tanggal !== $rowbefore){	
								echo '<td>';
								if($stats[$i]->sentiment == 'm'){
										echo $stats[$i]->jumlah;
									}elseif($i+1<count($stats) && $stats[$i]->tanggal == $stats[$i+1]->tanggal && $stats[$i+1]->sentiment == 'm'){
										echo $stats[$i+1]->jumlah;
									}elseif($i+2<count($stats) && $stats[$i]->tanggal == $stats[$i+2]->tanggal && $stats[$i+2]->sentiment == 'm'){
										echo $stats[$i+2]->jumlah;
									}else{
										echo '0';
									}
								echo '</td>';
							}
						endfor; 
					?>
					</tr>

					<tr class="tr-" scope="row">
						<th scope="row">Netral</th>
					<?php 
						$rowbefore=''; 
						for($i=0; $i<count($stats); $i++): 
							if($i>0){
								$rowbefore = $stats[$i-1]->tanggal;
							}
							if($stats[$i]->tanggal !== $rowbefore){	
								echo '<td>';
								if($stats[$i]->sentiment == 'n'){
										echo $stats[$i]->jumlah;
									}elseif($i+1<count($stats) && $stats[$i]->tanggal == $stats[$i+1]->tanggal && $stats[$i+1]->sentiment == 'n'){
										echo $stats[$i+1]->jumlah;
									}elseif($i+2<count($stats) && $stats[$i]->tanggal == $stats[$i+2]->tanggal && $stats[$i+2]->sentiment == 'n'){
										echo $stats[$i+2]->jumlah;
									}else{
										echo '0';
									}
								echo '</td>';
							}
						endfor; 
					?>
					</tr>

					<tr class="tr-" scope="row">
						<th scope="row">Positif</th>
					<?php 
						$rowbefore=''; 
						for($i=0; $i<count($stats); $i++): 
							if($i>0){
								$rowbefore = $stats[$i-1]->tanggal;
							}
							if($stats[$i]->tanggal !== $rowbefore){	
								echo '<td>';
								if($stats[$i]->sentiment == 'p'){
										echo $stats[$i]->jumlah;
									}elseif($i+1<count($stats) && $stats[$i]->tanggal == $stats[$i+1]->tanggal && $stats[$i+1]->sentiment == 'p'){
										echo $stats[$i+1]->jumlah;
									}elseif($i+2<count($stats) && $stats[$i]->tanggal == $stats[$i+2]->tanggal && $stats[$i+2]->sentiment == 'p'){
										echo $stats[$i+2]->jumlah;
									}else{
										echo '0';
									}
								echo '</td>';
							}
						endfor; 
					?>
					</tr>
				</tbody>
				<?php endif; ?>
			</table>

	</div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>