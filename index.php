
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-body {
            padding: 20px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .delete-car, .update-car {
            float: right;
            margin-left: 10px;
        }
    </style>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to fetch and display cars list
            function fetchCars() {
                $.ajax({
                    url: 'http://localhost:8000/api/cars/',
                    method: 'GET',
                    success: function(response) {
                        if(response.status === "success") {
                            var cars = response.data;
                            var carsList = $('#cars-list');
                            carsList.empty();
                            cars.forEach(function(car) {
                                carsList.append(`
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">${car.care_name}</h5>
                                            <p class="card-text"><strong>Version:</strong> ${car.car_version}</p>
                                            <p class="card-text"><strong>Model:</strong> ${car.car_model}</p>
                                            <button class="btn btn-danger delete-car" data-id="${car.id}"><i class="fas fa-trash"></i> Delete</button>
                                            <button class="btn btn-primary update-car" data-id="${car.id}"><i class="fas fa-edit"></i> Update</button>
                                        </div>
                                    </div>
                                `);
                            });

                            // Attach delete event to buttons
                            $('.delete-car').click(function() {
                                var carId = $(this).data('id');
                                deleteCar(carId);
                            });

                            // Attach update event to buttons
                            $('.update-car').click(function() {
                                var carId = $(this).data('id');
                                populateForm(carId);
                            });
                        } else {
                            alert('Failed to fetch cars list');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error fetching cars list: ' + xhr.responseText);
                    }
                });
            }

            // Function to delete a car
            function deleteCar(id) {
                $.ajax({
                    url: `http://localhost:8000/api/cars/${id}/`,
                    method: 'DELETE',
                    success: function(response) {
                        if(response.status === "success") {
                            fetchCars();
                        } else {
                            alert('Failed to delete car');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting car: ' + xhr.responseText);
                    }
                });
            }

            // Function to populate form for updating a car
            function populateForm(id) {
                $.ajax({
                    url: `http://localhost:8000/api/cars/${id}/`,
                    method: 'GET',
                    success: function(response) {
                        if(response.status === "success") {
                            var car = response.data;
                            $('#car_name').val(car.care_name);
                            $('#car_version').val(car.car_version);
                            $('#car_model').val(car.car_model);

                            // Change submit button to update mode
                            $('#create-car-form').attr('data-id', id);
                            $('#create-car-btn').html('<i class="fas fa-sync"></i> Update Car');
                        } else {
                            alert('Failed to fetch car details for update');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error fetching car details: ' + xhr.responseText);
                    }
                });
            }

            // Function to handle form submission for both create and update
            $('#create-car-form').on('submit', function(e) {
                e.preventDefault();
                var carName = $('#car_name').val();
                var carVersion = $('#car_version').val();
                var carModel = $('#car_model').val();
                var carId = $(this).attr('data-id');

                if(carId) {
                    // Update existing car
                    updateCar(carId, carName, carVersion, carModel);
                } else {
                    // Create new car
                    createCar(carName, carVersion, carModel);
                }
            });

            // Function to create a new car
            function createCar(carName, carVersion, carModel) {
                $.ajax({
                    url: 'http://localhost:8000/api/cars/',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        care_name: carName,
                        car_version: carVersion,
                        car_model: carModel
                    }),
                    success: function(response) {
                        if(response.status === "success") {
                            $('#create-car-form')[0].reset();
                            fetchCars();
                        } else {
                            alert('Failed to create car: ' + JSON.stringify(response.data));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error creating car: ' + xhr.responseText);
                    }
                });
            }

            // Function to update an existing car
            function updateCar(id, carName, carVersion, carModel) {
                $.ajax({
                    url: `http://localhost:8000/api/cars/${id}/`,
                    method: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        care_name: carName,
                        car_version: carVersion,
                        car_model: carModel
                    }),
                    success: function(response) {
                        if(response.status === "success") {
                            $('#create-car-form')[0].reset();
                            fetchCars();
                            // Reset form and button to create mode
                            $('#create-car-form').removeAttr('data-id');
                            $('#create-car-btn').html('<i class="fas fa-plus"></i> Create Car');
                        } else {
                            alert('Failed to update car: ' + JSON.stringify(response.data));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating car: ' + xhr.responseText);
                    }
                });
            }

            // Initial fetch of cars
            fetchCars();
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Car Management System</div>
            <div class="card-body">
                <form id="create-car-form">
                    <div class="form-group">
                        <label for="car_name">Car Name:</label>
                        <input type="text" class="form-control" id="car_name" name="car_name" required>
                    </div>
                    <div class="form-group">
                        <label for="car_version">Car Version:</label>
                        <input type="text" class="form-control" id="car_version" name="car_version" required>
                    </div>
                    <div class="form-group">
                        <label for="car_model">Car Model:</label>
                        <input type="text" class="form-control" id="car_model" name="car_model" required>
                    </div>
                    <button type="submit" id="create-car-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Create Car</button>
                </form>
            </div>
        </div>

        <h2 class="mt-4 mb-3">Cars List</h2>
        <div id="cars-list">
            <!-- Cars will be dynamically appended here -->
        </div>
    </div>
</body>
</html>
