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
                    <h1>Edit Customer Data</h1>
                </div>
                <div class="body">
                    <form method="POST" action="{{ route('customers.update', $customer->id) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label>Customer Name </label>
                            <input class="form-control" type="text" name="name" value="{{ $customer->name }}"
                                placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label>Gender </label>
                            <div class="form-check">
                                <input id="male" class="form-check-input" type="radio" name="gender"
                                    value="Male" {{ $customer->gender == 'Male' ? 'checked' : '' }}>
                                <label for="male" class="form-check-label">Male</label>
                            </div>

                            <div class="form-check">
                                <input id="female" class="form-check-input" type="radio" name="gender"
                                    value="Female" {{ $customer->gender == 'Female' ? 'checked' : '' }}>
                                <label for="female" class="form-check-label">Female</label>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="">Payment</label>
                            <div class="form-check">
                                <input id="Cash" class="form-check-input" type="checkbox" name="payment[]"
                                    value="Cash" {{ in_array('Cash', $customer->payment) ? 'checked' : '' }}>
                                <label for="Cash" class="form-check-label">Cash</label>
                            </div>
                            <div class="form-check">
                                <input id="Online" class="form-check-input" type="checkbox" name="payment[]"
                                    value="Online" {{ in_array('Online', $customer->payment) ? 'checked' : '' }}>
                                <label for="Online" class="form-check-label">Online</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Country">Country</label>
                            <select id="" class="form-control" name="country">
                                <option>Select Country </option>
                                <option value="India" {{ $customer->country == 'India' ? 'selected' : '' }}>India
                                </option>
                                <option value="Nepal" {{ $customer->country == 'Nepal' ? 'selected' : '' }}>Nepal
                                </option>
                                <option value="China" {{ $customer->country == 'China' ? 'selected' : '' }}>China
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Profile">Profile</label>
                            <input class="form-control-file" type="file" name="image">
                            <img src="{{ asset('storage/' . $customer->profile) }}" width=50 height=50>
                        </div>
                        <div class="form-group">
                            <button type="submit">Update </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



</body>

</html>
