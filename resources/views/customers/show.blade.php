<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1 class="">Customer Data Show</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Title</h5>
                    {{-- <p class="card-text">Content</p> --}}

                    <ul class="list-group">
                        <li class="list-group-item  ">Customer Name : {{ $customer->name }}</li>
                        <li class="list-group-item  ">Customer Gender : {{ $customer->gender }}</li>

                        <li class="list-group-item  ">Customer Payment : {{ implode(' ,', $customer->payment) }}</li>

                        <li class="list-group-item  ">Customer Country : {{ $customer->country }}</li>
                        {{-- {{dd($customer->profile)}}; --}}
                        <li class="list-group-item ">
                            Customer Profile : <img class="img-fluid" src="{{ asset('storage/' . $customer->profile) }}"
                                alt="no image found" width=80 height=80>
                        </li>

                        <ul class="list-group mt-3">
                            <a href="{{ route('customers.index') }}"><button class="btn btn-lg bg-danger w-100">Back </button> </a>                           
                        </ul>

               
                    </ul>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
