<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ Helper::Email_Subject(15) }}</title>
</head>
<body class="preload dashboard-upload">
@php echo html_entity_decode(Helper::Email_Content(15,["{{product_url}}"],["$product_url"])) @endphp
</body>
</html>