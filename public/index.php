<h1>Veikals</h1>

<?php
require __DIR__ . '/../db/connect.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($requestUri === '/customers') {
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Klientu saraksts</h2>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Vārds</th>
                    <th>Uzvārds</th>
                    <th>E-pasts</th>
                    <th>Dzimšanas datums</th>
                    <th>Punkti</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["customer_id"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["last_name"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["birthday"] . "</td>
                    <td>" . $row["points"] . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nav atrasts neviens klients.";
    }
}
?>
