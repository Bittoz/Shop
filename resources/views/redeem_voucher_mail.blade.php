<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(25) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(25,["{{voucher_code}}","{{credits}}","{{currency}}"],["$voucher_code","$credits","$currency"])) @endphp
</body>
</html>