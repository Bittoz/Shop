<p>Hello,</p>

<p>Thank you for your purchase. Here are your account credentials for <strong>{{ $product_name }}</strong>:</p>

<ul>
  <li><strong>Username:</strong> {{ $username }}</li>
  <li><strong>Password:</strong> {{ $password }}</li>
  @if($note)
    <li><strong>Note:</strong> {{ $note }}</li>
  @endif
</ul>

<p>We recommend changing the password after your first login.</p>

<p>Best regards,<br>The {{ config('app.name') }} Team</p>
