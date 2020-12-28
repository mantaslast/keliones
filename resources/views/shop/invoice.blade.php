<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sąskaita - Faktūra</title>

<style type="text/css">
  * { font-family: DejaVu Sans, sans-serif; }

    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
</style>

</head>
<body>

  <table width="100%">
    <tr>
        <td valign="top">
            <img src="{{ public_path() . '/images/logo.png'}}" alt="" width="150"/>
        </td>
        <td align="right">
            <h3>Travel</h3>
            <pre>
                Travel
                Kompanijos adresas
                Tax ID
                Telefonas
                Faksas
            </pre>
        </td>
    </tr>

  </table>

  <br/>

  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Apibūdinimas</th>
        <th>Kiekis</th>
        <th>Vnt. kaina</th>
        <th>Viso &euro;</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>{{$order->offer->name}}</td>
        <td align="right">1</td>
        <td align="right">{{$order->offer->price}}</td>
        <td align="right">{{$order->offer->price}}</td>
      </tr>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3"></td>
            <td align="right">Viso &euro;</td>
            <td align="right" class="gray">{{round($order->offer->price, 2)}}<</td>
        </tr>
    </tfoot>
  </table>

</body>
</html>