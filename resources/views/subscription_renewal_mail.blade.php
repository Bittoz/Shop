<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(23) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(23,["{{expired_date}}","{{pack_name}}","{{from_email}}", "{{from_name}}", "{{subscription_url}}"],["$expired_date","$pack_name","$from_email", "$from_name", "$subscription_url"])) @endphp
</body>
</html>