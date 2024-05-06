<!DOCTYPE html>
<html>
    <head>
        <title>Registracija vozila</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
    </head>
    <body style="max-width:85%">
<?php

$host = "localhost:3306";
$username = "root";
$password = "1234";
$dbname = "reg_vozila";

$conn = mysqli_connect($host, $username, $password, $dbname);

if(!$conn) {

    die("Connection error: " . mysqli_connect_error());
}

$sql = "SELECT * FROM vozilo";

$stmt = mysqli_query($conn, $sql);

echo '<table><thead><tr>
    <th>Jedinstveni broj</th>
    <th>Marka</th>
    <th>Tip</th>
    <th>Model</th>
    <th>VIN</th>
    <th>Masa</th>
    <th>Zapremina motora</th>
    <th>Snaga motora</th>
    <th>Tip goriva</th>
    <th>Godina proizvodnje</th>
    <th>Boja</th>
    <th>Kategorija vozila</th>
    <th>Vlasnik</th>
    </tr></thead>';

echo '<tbody>';

while($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

    echo '<tr>';
    echo '<td>'.$row['vozilo_id'].'</td>';
    echo '<td>'.$row['marka'].'</td>';
    echo '<td>'.$row['tip'].'</td>';
    echo '<td>'.$row['model'].'</td>';
    echo '<td>'.$row['broj_šasije'].'</td>';
    echo '<td>'.$row['masa'].'</td>';
    echo '<td>'.$row['zapremina'].'</td>';
    echo '<td>'.$row['snaga'].'</td>';
    echo '<td>'.$row['gorivo'].'</td>';
    echo '<td>'.$row['godište'].'</td>';
    echo '<td>'.$row['boja'].'</td>';
    echo '<td>'.$row['kategorija'].'</td>';
    echo '<td>'.$row['vlasnik'].'</td>';
    echo '</tr>';
}

echo '</tbody></table>'; ?>
    </body>
</html>