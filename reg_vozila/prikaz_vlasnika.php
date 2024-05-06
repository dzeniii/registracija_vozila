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

$sql = "SELECT * FROM vlasnik";

$stmt = mysqli_query($conn, $sql);

echo '<table><thead><tr>
    <th>Lična</th>
    <th>Ime</th>
    <th>Prezime</th>
    <th>Općina</th>
    <th>Mjesto</th>
    <th>Adresa</th>
    </tr></thead>';

echo '<tbody>';

while($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {

    echo '<tr>';
    echo '<td>'.$row['lična_karta'].'</td>';
    echo '<td>'.$row['ime'].'</td>';
    echo '<td>'.$row['prezime'].'</td>';
    echo '<td>'.$row['općina'].'</td>';
    echo '<td>'.$row['mjesto'].'</td>';
    echo '<td>'.$row['adresa'].'</td>';
    echo '</tr>';
}

echo '</tbody></table>'; ?>
    </body>
</html>