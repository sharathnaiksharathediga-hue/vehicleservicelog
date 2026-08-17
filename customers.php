<?php

$file = "data/customers.json";

if (!file_exists($file)) {
    file_put_contents($file, "[]");
}

$customers = json_decode(file_get_contents($file), true);

if (!is_array($customers)) {
    $customers = [];
}


/* ADD CUSTOMER */

if (isset($_POST['add_customer'])) {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if ($name == "" || $phone == "") {

        $error = "Name and phone are required.";

    } else {

        $customer = [
            "id" => uniqid(),
            "name" => $name,
            "phone" => $phone,
            "email" => $email
        ];

        $customers[] = $customer;

        file_put_contents(
            $file,
            json_encode($customers, JSON_PRETTY_PRINT),
            LOCK_EX
        );

        $success = "Customer added successfully.";
    }
}


/* DELETE CUSTOMER */

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    foreach ($customers as $key => $customer) {

        if ($customer['id'] == $id) {

            unset($customers[$key]);

            break;
        }
    }

    $customers = array_values($customers);

    file_put_contents(
        $file,
        json_encode($customers, JSON_PRETTY_PRINT),
        LOCK_EX
    );

    header("Location: customers.php");

    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Customers</title>

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

<h2>Customers</h2>

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


<!-- ADD CUSTOMER -->

<div class="form-box">

<h3>Add Customer</h3>

<form method="POST">

    <label>Name</label>

    <input
        type="text"
        name="name"
        required
    >

    <label>Phone</label>

    <input
        type="text"
        name="phone"
        required
    >

    <label>Email</label>

    <input
        type="email"
        name="email"
    >

    <button
        type="submit"
        name="add_customer"
    >
        Add Customer
    </button>

</form>

</div>


<!-- CUSTOMER LIST -->

<h3>Customer List</h3>

<table>

<tr>

    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Action</th>

</tr>

<?php foreach ($customers as $customer): ?>

<tr>

    <td>
        <?php echo htmlspecialchars($customer['name']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($customer['phone']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($customer['email']); ?>
    </td>

    <td>

        <a
            class="delete"
            href="customers.php?delete=<?php echo $customer['id']; ?>"
            onclick="return confirm('Delete this customer?')"
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