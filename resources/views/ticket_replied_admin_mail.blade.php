<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(28) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(28,["{{from_name}}","{{from_email}}","{{tickets_token}}","{{tickets_message}}"],["$from_name","$from_email","$tickets_token","$tickets_message"])) @endphp
</body>
</html>