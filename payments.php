<?php

$file = "data/payments.json";

if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

$payments = json_decode(file_get_contents($file), true);

if (!is_array($payments)) {
    $payments = [];
}


/* ADD PAYMENT */

if (isset($_POST['add_payment'])) {

    $vehicle = trim($_POST['vehicle']);
    $amount = floatval($_POST['amount']);
    $method = trim($_POST['method']);

    if ($vehicle == "" || $amount <= 0) {

        $error = "Please enter valid payment details.";

    } else {

        $payment = [

            "id" => uniqid(),

            "vehicle" => $vehicle,

            "amount" => $amount,

            "method" => $method,

            "date" => date("Y-m-d")

        ];

        $payments[] = $payment;

        file_put_contents(
            $file,
            json_encode($payments, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        $success = "Payment added successfully.";
    }
}


/* DELETE */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    foreach ($payments as $key => $payment) {

        if ($payment['id'] == $id) {

            unset($payments[$key]);

            break;
        }
    }

    $payments = array_values($payments);

    file_put_contents(
        $file,
        json_encode($payments, JSON_PRETTY_PRINT),
        LOCK_EX
    );

    header("Location: payments.php");

    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Payments</title>

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

<h2>Payments</h2>


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

<h3>Add Payment</h3>

<form method="POST">

<label>Vehicle Number</label>

<input
    type="text"
    name="vehicle"
    required
>

<label>Amount</label>

<input
    type="number"
    name="amount"
    min="1"
    required
>

<label>Payment Method</label>

<select name="method">

<option value="Cash">Cash</option>
<option value="UPI">UPI</option>
<option value="Card">Card</option>
<option value="Bank Transfer">Bank Transfer</option>

</select>

<button
    type="submit"
    name="add_payment"
>
Add Payment
</button>

</form>

</div>


<h3>Payment History</h3>

<table>

<tr>

<th>Date</th>
<th>Vehicle</th>
<th>Amount</th>
<th>Method</th>
<th>Action</th>

</tr>


<?php foreach ($payments as $payment): ?>

<tr>

<td>
<?php echo $payment['date']; ?>
</td>

<td>
<?php echo htmlspecialchars($payment['vehicle']); ?>
</td>

<td>
₹<?php echo number_format($payment['amount'], 2); ?>
</td>

<td>
<?php echo htmlspecialchars($payment['method']); ?>
</td>

<td>

<a
class="delete"
href="payments.php?delete=<?php echo $payment['id']; ?>"
onclick="return confirm('Delete this payment?')"
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