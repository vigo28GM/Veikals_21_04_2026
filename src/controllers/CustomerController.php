<?php

class CustomerController {
    public static function index() {
        $result = DB::query("SELECT * FROM customers");

        $output = "<h2>Klientu saraksts</h2>";
        if ($result->rowCount() > 0) {
            $output .= "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>Vārds</th>
                        <th>Uzvārds</th>
                        <th>E-pasts</th>
                        <th>Dzimšanas datums</th>
                        <th>Punkti</th>
                    </tr>";
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $output .= "<tr>
                        <td>" . $row["customer_id"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["last_name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["birthday"] . "</td>
                        <td>" . $row["points"] . "</td>
                      </tr>";
            }
            $output .= "</table>";
        } else {
            $output .= "Nav atrasts neviens klients.";
        }
        return $output;
    }
}
?>
