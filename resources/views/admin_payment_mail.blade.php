<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(21) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(21,["{{final_amount}}","{{currency}}","{{from_name}}","{{from_email}}","{{purchased_token}}","{{download_file}}"],["$final_amount","$currency","$from_name","$from_email","$purchased_token","$download_file"])) @endphp
</body>
</html>