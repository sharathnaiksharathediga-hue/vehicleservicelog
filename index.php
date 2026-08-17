<?php

function countData($file)
{
    if (!file_exists($file)) {
        return 0;
    }

    $data = json_decode(file_get_contents($file), true);

    return is_array($data) ? count($data) : 0;
}

$customers = countData("data/customers.json");
$vehicles  = countData("data/vehicles.json");
$services  = countData("data/services.json");
$payments  = countData("data/payments.json");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Vehicle Service Center</title>

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

    <h2>Dashboard</h2>

    <div class="cards">

        <div class="card">
            <h3>Customers</h3>
            <p><?php echo $customers; ?></p>
            <a href="customers.php">Manage</a>
        </div>

        <div class="card">
            <h3>Vehicles</h3>
            <p><?php echo $vehicles; ?></p>
            <a href="vehicles.php">Manage</a>
        </div>

        <div class="card">
            <h3>Services</h3>
            <p><?php echo $services; ?></p>
            <a href="services.php">Manage</a>
        </div>

        <div class="card">
            <h3>Payments</h3>
            <p><?php echo $payments; ?></p>
            <a href="payments.php">Manage</a>
        </div>

    </div>

</main>

</body>
</html>