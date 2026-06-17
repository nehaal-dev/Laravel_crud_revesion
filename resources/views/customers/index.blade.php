<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    {{-- php artisan storage:link --}}
   
    <h1>CUSTOMER TABLE </h1> 
    <a href="{{ route('customers.create') }}"><button class="btn btn-lg bg-danger ">Create customer </button> </a>                           
 


    <table class="table">
        <tr>
            <th>ID</th>
            <th>CUSTOMER NAME</th>
            <th>GENDER</th>
            <th>PAYMENT</th>
            <th>COUNTRY</th>
            <th>IMAGE</th>
            <th>SHOW</th>
            <th>EDIT</th>
            <th>DELETE</th>
        </tr>
        <tbody>
            @foreach ($customer_data as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->gender }}</td>
                    <td>
                        @foreach ($data->payment as $p)
                            <span class="badge badge-info">{{ $p }}</span>
                        @endforeach
                    </td>
                    {{-- <td>{{implode(',' , $data->payment)}}</td> --}}
                    {{-- <td>{{join(',' , $data->payment) }} </td> --}}



                    <td>{{ $data->country }}</td>
                    <td><img src="{{ asset('storage/' . $data->profile) }}" width=50 height=50></td>

                    <td>
                         <a href="{{ route('customers.show', $data->id) }}"><button
                                class="btn btn-primary">SHOW</button> </a>
                   </td>
                    <td>
                    <a href="{{ route('customers.edit', $data->id) }}"><button class="btn btn-info">EDIT</button>
                        </a>
                    </td>

                    <td>
                    <form method="POST" action="{{ route('customers.destroy', $data->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary">DELETE</button>
                    </form>
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>

</body>

</html>
