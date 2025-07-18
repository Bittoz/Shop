<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(24) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(24,["{{product_name}}","{{product_slug}}","{{from_name}}","{{from_email}}","{{report_subject}}","{{report_message}}","{{report_issue_type}}"],["$product_name","$product_slug","$from_name","$from_email","$report_subject","$report_message","$report_issue_type"])) @endphp
</body>
</html>