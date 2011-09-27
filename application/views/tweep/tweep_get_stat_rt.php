<h2>ReTweet statistic</h2>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Total Tweet</div>
    <div class="number" id="number-tweet-found"><?php echo $rt->tweets ?></div>
</div>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Total Re-Tweets</div>
    <div class="number" id="number-user-participate"><?php echo $rt->retweets ?></div>
</div>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Total User Retweeted</div>
    <div class="number" id="number-tweet-impression"><?php echo $rt->users ?></div>
</div>
<div class="statistic-num ui-button ui-widget ui-state-default ui-corner-all">
    <div>Total Impression</div>
    <div class="number" id="number-tweet-impression"><?php echo $rt->followers ?></div>
</div>
<div class="clear"></div>