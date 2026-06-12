<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
    crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <h1>CUSTOMER TABLE </h1>

    <table class="table table-dark">
        <tr>  
            <th>ID</th> <th>CUSTOMER NAME</th><th>GENDER</th><th>PAYMENT</th><th>COUNTRY</th>
            <th>IMAGE</th><th>EDIT</th><th>SHOW</th><th>DELETE</th>
        </tr>
        <tbody>
            @foreach ($customer_data as $data )
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->gender}}</td>
                <td>{{$data->payment}}</td>
                <td>{{$data->country}}</td>
                <td>{{$data->profile}}</td>
             
            </tr>
                
            @endforeach
            
        </tbody>
    </table>

       </body>
</html>