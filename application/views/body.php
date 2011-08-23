<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <base href="<?php echo base_url() . 'themes/' . config_item('app_themes'); ?>/"/>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="site_url" content="<?php echo site_url() ?>" />
        <meta name="base_url" content="<?php echo base_url() ?>" />
        <meta name="current_url" content="<?php echo current_url() ?>" />

        <title><?php echo config_item('app_title'); ?></title>
        <link rel="stylesheet" href="css/backends.css" type="text/css" media="screen" title="" charset="utf-8" />
        <link rel="stylesheet" href="js/jquery-ui/css/flick/jquery-ui.css" type="text/css" media="screen" title="" charset="utf-8" />

        <?php if ( isset($styles) ): ?>
            <?php foreach ($styles as $j): ?>
                <link type="text/css" href="<?php echo $j ?>" rel="stylesheet" />
            <?php endforeach ?>
        <?php endif; ?>

        <script type="text/javascript" src="js/jquery-ui/js/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>

        <?php if ( isset($javascripts) ): ?>
            <?php foreach ($javascripts as $j): ?>
                <script type="text/javascript" src="<?php echo $j ?>"></script>
            <?php endforeach ?>
        <?php endif; ?>

        <script type="text/javascript" src="js/global.js"></script>
    </head>

    <body>

        <div id="hld">
            <div class="wrapper">

                <?php $this->load->view('header'); ?>
                <?php echo $content; ?>


                <div id="footer">
                    <p class="left"><a href="<?php echo site_url() ?>"><?php config_item('app_title') ?></a></p>
                    <p class="right">
                        created by <a href="http://twitter.com/bhasunjaya" target="_blank" >erwin handoko</a>
                    </p>
                </div>


            </div>
            <!-- wrapper ends -->

        </div>
        <!-- #hld ends -->

    </body>
</html>