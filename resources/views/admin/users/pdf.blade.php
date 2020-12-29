<!DOCTYPE html>
<html>
<head>
	<title>Vartotojai</title>
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
					<th>Vardas</th>
					<th>El. paštas</th>
					<th>Rolė</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{$user['id']}}</td>
					<td>{{$user['name']}}</td>
					<td>{{$user['email']}}</td>
					<td>{{$user['role']}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>

</body>
</html>