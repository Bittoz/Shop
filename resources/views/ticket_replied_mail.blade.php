<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(27) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(27,["{{from_name}}","{{from_email}}","{{tickets_token}}","{{tickets_message}}"],["$from_name","$from_email","$tickets_token","$tickets_message"])) @endphp
</body>
</html>