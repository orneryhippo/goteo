<?php

$error = $this->error;
$message = $this->message;

$this->layout('user/layout');

$this->section('inner-content');

?>

<div style="padding:0 8%">

    <h2 class="padding-bottom-6"><?= $this->text('newsletter-unsubscribe') ?></h2>


    <?php if ($error): ?>
        <p class="text-danger"><?= $error ?></p>
    <?php endif ?>

    <?php if ($message): ?>
        <p><?= $message ?></p>
        <p><?= $this->text('newsletter-unsubscribe-cancel', '/user/subscribe/' . $this->token) ?></p>
    <?php endif ?>

</div>

<?php $this->replace() ?>

