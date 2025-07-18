<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo e(Helper::Email_Subject(9)); ?></title>
</head>
<body class="preload dashboard-upload">
<?php echo html_entity_decode(Helper::Email_Content(9,["{{email}}","{{register_url}}"],["$email","$register_url"])) ?>
</body>
</html><?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/register_mail.blade.php ENDPATH**/ ?>