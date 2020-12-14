<!DOCTYPE html>
<html>
<head>
	<title>Pasiūlymai</title>
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
					<th>Pavadinimas</th>
					<th>Miestas</th>
					<th>Šalis</th>
					<th>Kategorija</th>
					<th>Kaina</th>
				</tr>
			</thead>
			<tbody>
				@foreach($offers as $offer)
				<tr>
					<td>{{$offer['id']}}</td>
					<td>{{$offer['name']}}</td>
					<td>{{$offer['city']}}</td>
					<td>{{$offer['country']}}</td>
					<td>{{$offer['category_name']}}</td>
					<td>{{$offer['price']}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

</body>
</html>