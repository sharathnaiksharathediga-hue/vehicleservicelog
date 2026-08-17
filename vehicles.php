<?php

$file = "data/vehicles.json";

if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

$vehicles = json_decode(file_get_contents($file), true);

if (!is_array($vehicles)) {
    $vehicles = [];
}


/* ADD VEHICLE */

if (isset($_POST['add_vehicle'])) {

    $number = trim($_POST['number']);
    $model = trim($_POST['model']);
    $type = trim($_POST['type']);

    if ($number == "" || $model == "") {

        $error = "Vehicle number and model are required.";

    } else {

        $vehicle = [
            "id" => uniqid(),
            "number" => $number,
            "model" => $model,
            "type" => $type
        ];

        $vehicles[] = $vehicle;

        file_put_contents(
            $file,
            json_encode($vehicles, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        $success = "Vehicle added successfully.";
    }
}


/* DELETE */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    foreach ($vehicles as $key => $vehicle) {

        if ($vehicle['id'] == $id) {

            unset($vehicles[$key]);

            break;
        }
    }

    $vehicles = array_values($vehicles);

    file_put_contents(
        $file,
        json_encode($vehicles, JSON_PRETTY_PRINT),
        LOCK_EX
    );

    header("Location: vehicles.php");

    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Vehicles</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="style/style.css">

</head>

<body>

<header>

<h1>Vehicle Service Center</h1>

<nav>

<a href="index.php">Dashboard</a>
<a href="customers.php">Customers</a>
<a href="vehicles.php">Vehicles</a>
<a href="services.php">Services</a>
<a href="payments.php">Payments</a>

</nav>

</header>

<main>

<h2>Vehicles</h2>

<?php if (isset($success)): ?>

<div class="success">
<?php echo $success; ?>
</div>

<?php endif; ?>


<?php if (isset($error)): ?>

<div class="error">
<?php echo $error; ?>
</div>

<?php endif; ?>


<div class="form-box">

<h3>Add Vehicle</h3>

<form method="POST">

<label>Vehicle Number</label>

<input
    type="text"
    name="number"
    placeholder="KA01AB1234"
    required
>

<label>Vehicle Model</label>

<input
    type="text"
    name="model"
    placeholder="Swift"
    required
>

<label>Vehicle Type</label>

<select name="type">

<option value="Car">Car</option>
<option value="Bike">Bike</option>
<option value="SUV">SUV</option>
<option value="Other">Other</option>

</select>

<button
    type="submit"
    name="add_vehicle"
>
Add Vehicle
</button>

</form>

</div>


<h3>Vehicle List</h3>

<table>

<tr>

<th>Number</th>
<th>Model</th>
<th>Type</th>
<th>Action</th>

</tr>

<?php foreach ($vehicles as $vehicle): ?>

<tr>

<td>
<?php echo htmlspecialchars($vehicle['number']); ?>
</td>

<td>
<?php echo htmlspecialchars($vehicle['model']); ?>
</td>

<td>
<?php echo htmlspecialchars($vehicle['type']); ?>
</td>

<td>

<a
class="delete"
href="vehicles.php?delete=<?php echo $vehicle['id']; ?>"
onclick="return confirm('Delete this vehicle?')"
>
Delete
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</main>

</body>

</html>