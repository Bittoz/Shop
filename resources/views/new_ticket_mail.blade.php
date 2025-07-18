<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(26) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(26,["{{from_name}}","{{from_email}}","{{ticket_token}}","{{ticket_subject}}","{{ticket_priority}}","{{ticket_message}}"],["$from_name","$from_email","$ticket_token","$ticket_subject","$ticket_priority","$ticket_message"])) @endphp
</body>
</html>