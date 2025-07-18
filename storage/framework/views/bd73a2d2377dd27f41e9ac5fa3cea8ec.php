<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo e(Helper::Email_Subject(6)); ?></title>
</head>
<body class="preload dashboard-upload">
<?php echo html_entity_decode(Helper::Email_Content(6,["{{activate_url}}"],["$activate_url"])) ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/newsletter_mail.blade.php ENDPATH**/ ?>