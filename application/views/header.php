<div id="header">
    <div class="hdrl"></div>
    <div class="hdrr"></div>

    <h1><a href="<?php echo site_url() ?>"><?php echo $this->config->item('app_title'); ?></a></h1>

    <ul id="nav">
        <li><a href="<?php echo site_url('') ?>">Dashboard</a></li>
        <li><a href="<?php echo site_url('account') ?>">Accounts</a></li>
        <li><a href="<?php echo site_url('keyword') ?>">Keywords</a></li>
		<li><a href="<?php echo site_url('mydashboard') ?>">My Dashboard</a></li>
		<li><a href="<?php echo site_url('grabuser') ?>">Twitter User</a></li>
		<li><a href="<?php echo site_url('mydashboard/user') ?>">User</a></li>
        <li><a href="<?php echo site_url('engine') ?>">Engine</a></li>
		<li><a href="<?php echo site_url('ionauth/logout') ?>">Logout</a></li>
    </ul>
</div>