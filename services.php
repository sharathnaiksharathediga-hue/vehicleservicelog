<?php

$file = "data/services.json";

if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

$services = json_decode(file_get_contents($file), true);

if (!is_array($services)) {
    $services = [];
}


/* ADD SERVICE */

if (isset($_POST['add_service'])) {

    $vehicle = trim($_POST['vehicle']);
    $service = trim($_POST['service']);
    $amount = floatval($_POST['amount']);

    if ($vehicle == "" || $service == "" || $amount <= 0) {

        $error = "Please enter valid service details.";

    } else {

        $newService = [

            "id" => uniqid(),

            "vehicle" => $vehicle,

            "service" => $service,

            "amount" => $amount,

            "date" => date("Y-m-d")

        ];

        $services[] = $newService;

        file_put_contents(
            $file,
            json_encode($services, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        $success = "Service added successfully.";
    }
}


/* DELETE */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    foreach ($services as $key => $service) {

        if ($service['id'] == $id) {

            unset($services[$key]);

            break;
        }
    }

    $services = array_values($services);

    file_put_contents(
        $file,
        json_encode($services, JSON_PRETTY_PRINT),
        LOCK_EX
    );

    header("Location: services.php");

    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Services</title>

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

<h2>Services</h2>


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

<h3>Add Service</h3>

<form method="POST">

<label>Vehicle Number</label>

<input
    type="text"
    name="vehicle"
    required
>

<label>Service</label>

<input
    type="text"
    name="service"
    placeholder="Oil Change"
    required
>

<label>Amount</label>

<input
    type="number"
    name="amount"
    min="1"
    required
>

<button
    type="submit"
    name="add_service"
>
Add Service
</button>

</form>

</div>


<h3>Service History</h3>

<table>

<tr>

<th>Date</th>
<th>Vehicle</th>
<th>Service</th>
<th>Amount</th>
<th>Action</th>

</tr>

<?php foreach ($services as $service): ?>

<tr>

<td>
<?php echo $service['date']; ?>
</td>

<td>
<?php echo htmlspecialchars($service['vehicle']); ?>
</td>

<td>
<?php echo htmlspecialchars($service['service']); ?>
</td>

<td>
₹<?php echo number_format($service['amount'], 2); ?>
</td>

<td>

<a
class="delete"
href="services.php?delete=<?php echo $service['id']; ?>"
onclick="return confirm('Delete this service?')"
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