<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo e(Helper::Email_Subject(3)); ?></title>
</head>
<body class="preload dashboard-upload">
<?php echo html_entity_decode(Helper::Email_Content(3,["{{from_name}}","{{from_email}}","{{message_text}}"],["$from_name","$from_email","$message_text"])) ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/contact_mail.blade.php ENDPATH**/ ?>