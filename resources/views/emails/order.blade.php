<!DOCTYPE html>
<html>
<head>
	<title>Order Completed</title>
</head>
<body>
<p>Hi, {{$user->firstname}},</p>
<p>Your order has been completed successfully.</p>
<p>Details:</p>
<p>
  Name: {{$product->name}}<br>
  Price: {{$product->price}} euros<br>
  Date: {{date('d F, Y')}}<br>
  Reference: {{$transaction->payment_reference}}
</p>
<p>
  Note: Order will be delivered to you in the student union two days from now.
</p>
<p>
  Regards, <br>
  Admin
</p>
</body>
</html>