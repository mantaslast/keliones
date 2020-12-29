<!DOCTYPE html>
<html>
<head>
	<title>Užsakymai</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style> 
 * { font-family: DejaVu Sans, sans-serif; }
</style>
</head>
<body>

		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Raktas</th>
					<th>Statusas</th>
					<th>El. paštas</th>
					<th>Pasiūlymas</th>
					<th>Kaina</th>
				</tr>
			</thead>
			<tbody>
				@foreach($orders as $order)
				<tr>
					<td>{{$order['id']}}</td>
					<td>{{$order['key']}}</td>
					<td>{{$order['status']}}</td>
					<td>{{$order['email']}}</td>
					<td>{{$order['offer_name']}}</td>
					<td>{{$order['price']}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

</body>
</html>