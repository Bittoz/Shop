<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(20) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(20,["{{user_subscr_type}}","{{subscr_date}}","{{subscri_date}}", "{{currency}}", "{{subscr_price}}"],["$user_subscr_type","$subscr_date","$subscri_date", "$currency", "$subscr_price"])) @endphp
</body>
</html>