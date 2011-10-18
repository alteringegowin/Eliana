<?php
$segment = $this->uri->segment(2, 'index');
$class_status = $segment == 'index' ? ' class="active"' : '';
$class_statistic = $segment == 'statistic' ? ' class="active"' : '';
$class_mention = $segment == 'mention' ? ' class="active"' : '';
$class_user = $segment == 'user' ? ' class="active"' : '';
$class_download = $segment == 'download' ? ' class="active"' : '';
?>
<ul>
    <li<?php echo $class_status?>><a href="<?php echo site_url('tweep/index/' . $tweep->user_id) ?>">Status</a></li>
    <li<?php echo $class_statistic?>><a href="<?php echo site_url('tweep/statistic/' . $tweep->user_id) ?>">Statistic</a></li>
    <li<?php echo $class_mention?>><a href="<?php echo site_url('tweep/mention/' . $tweep->user_id) ?>">Mention</a></li>
    <li<?php echo $class_user?>><a href="<?php echo site_url('tweep/user/' . $tweep->user_id) ?>">User</a></li>
    <li<?php echo $class_download?>><a href="<?php echo site_url('tweep/download/' . $tweep->user_id) ?>">Download Data</a></li>
</ul>