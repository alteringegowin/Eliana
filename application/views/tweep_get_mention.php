<?php
$diff = date_diffxx($mention->since, $mention->until);
$freq = number_format($mention->mentions/$diff['total'],4);
?>
<h2>Mentions statistic</h2>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Total mentions</div>
    <div class="number" id="number-tweet-found"><?php echo $mention->mentions ?></div>
</div>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Total users mention</div>
    <div class="number" id="number-user-participate"><?php echo $mention->users ?></div>
</div>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Mentions per Minutes</div>
    <div class="number" id="number-tweet-impression"><?php echo $freq ?></div>
</div>
<div class="clear"></div>

