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


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="header">
                    <h1>Create Customer </h1>
                </div>
                <div class="body">
                    <form method="POST" action="{{route('customers.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Customer Name </label>
                            <input class="form-control" type="text" name="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label>Gender </label>
                            <div class="form-check">
                                <input id="male" class="form-check-input" type="radio" name="gender"
                                    value="Male">
                                <label for="male" class="form-check-label">Male</label>
                            </div>

                            <div class="form-check">
                                <input id="female" class="form-check-input" type="radio" name="gender"
                                    value="Female">
                                <label for="female" class="form-check-label">Female</label>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="">Payment</label>
                            <div class="form-check">
                                <input id="Cash" class="form-check-input" type="checkbox" name="payment[]"
                                    value="Cash">
                                <label for="Cash" class="form-check-label">Cash</label>
                            </div>
                            <div class="form-check">
                                <input id="Online" class="form-check-input" type="checkbox" name="payment[]"
                                    value="Online">
                                <label for="Online" class="form-check-label">Online</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Country">Country</label>
                            <select id="" class="form-control" name="country">
                                <option>Select Country </option>
                                <option value="India">India</option>
                                <option value="Nepal">Nepal</option>
                                <option value="China">China</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="Profile">Profile</label>
                    <input id="" class="form-control-file" type="file" name="image" >
                </div>
                <div class="form-group">
                    <button type="submit">Save </button>
                </div>
                </form>
            </div>
        </div>
    </div>



</body>

</html>
