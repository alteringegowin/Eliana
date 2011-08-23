<div class="block ">
    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2><?php echo $title_atas ?></h2>
    </div>
    <div class="block_content">
        <?= form_open($act) ?>
        <p><?= form_error('recaptcha_response_field') ?></p>
        <p><?= $recaptcha ?></p>
        <p><?= form_submit('recaptchasubmit', $title_atas, "class='buttonUI'") ?></p>

        <?= form_close() ?>
    </div>		
    <!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>
</div>		
<!-- .login ends -->

