<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$database = "food_order_db";

$conn = new mysqli($host, $user, $password, $database);

$sql = "SELECT food_name, COUNT(*) AS order_count FROM orders GROUP BY food_name ORDER BY order_count DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <canvas id="ordersChart" width="400" height="200"></canvas>

    <script>
        const labels = [];
        const data = [];

        <?php while ($row = $result->fetch_assoc()): ?>
            labels.push("<?php echo $row['food_name']; ?>");
            data.push(<?php echo $row['order_count']; ?>);
        <?php endwhile; ?>

        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Most Ordered Foods',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
