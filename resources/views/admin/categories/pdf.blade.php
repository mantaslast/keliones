<!DOCTYPE html>
<html>
<head>
	<title>Kategorijos</title>
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
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
				<tr>
					<td>{{$category['id']}}</td>
					<td>{{$category['name']}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

</body>
</html>