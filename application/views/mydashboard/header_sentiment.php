<?php
$segment = $this->uri->segment(2, 'index');
$class_status = $segment == 'index' ? ' class="active"' : '';
$class_statistic = $segment == 'statistic' ? ' class="active"' : '';
$class_mention = $segment == 'mention' ? ' class="active"' : '';
$class_user = $segment == 'user' ? ' class="active"' : '';
?>
<ul>
    <li<?php echo $class_status?>><a href="<?php echo site_url('mydashboard/statistic/'.$keyword) ?>">Statistic </a></li>
	<!--<li<?php echo $class_status?>><a href="<?php echo site_url('mydashboard/tweet/'.$keyword) ?>">Keyword </a></li>-->
</ul>