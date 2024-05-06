<!DOCTYPE html>
<html>
    <head>
        <title>Registracija vozila</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
    </head>
    <body>
<?php

$host = "localhost:3306";
$username = "root";
$password = "1234";
$dbname = "reg_vozila";

$conn = mysqli_connect($host, $username, $password, $dbname);

if(!$conn) {

    die("Connection error: " . mysqli_connect_error());
}

$sql = "SELECT * FROM kategorija";

$stmt = mysqli_query($conn, $sql);

echo '<table><thead><tr>
    <th>Kategorija</th>
    <th>Naziv kategorije</th>
    <th>Cijena usluge tehničkog pregleda (BEZ PDV)</th>
    </tr></thead>';

echo '<tbody>';

while($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

    echo '<tr>';
    echo '<td>'.$row['kategorija'].'</td>';
    echo '<td>'.$row['naziv_kategorije'].'</td>';
    echo '<td>'.$row['cijena_tehničkog'].'KM</td>';
    echo '</tr>';
}

echo '</tbody></table>'; ?>
    </body>
</html>