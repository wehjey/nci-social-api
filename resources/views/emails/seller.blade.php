<!DOCTYPE html>
<html>
<head>
	<title>Product Sold</title>
</head>
<body>
<p>Hi {{ucwords($seller->firstname)}},</p>
<p>Product bought</p>
<p>Product Details:</p>
<p>
  Item: {{$product->name}}<br>
  Price: {{$product->price}} euros<br>
  Date: {{date('d F, Y')}}<br>
  Reference: {{$transaction->payment_reference}}
</p>
<p>Buyer Details:</p>
<p>
  Name: {{$buyer->firstname. ' ' .$buyer->lastname}}<br>
  Phone: {{$buyer->phone_number}}
</p>
<p>
  Note: Please contact buyer and make delivery in student union.
</p>
<p>
  Regards, <br>
  Admin
</p>
</body>
</html>