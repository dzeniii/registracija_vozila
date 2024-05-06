<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Uređivanje vlasnika</h1>
    <form action="uredi_vlasnika.php" method="post">

        <label for="licna">Unesite broj lične karte</label>
        <input type="text" name="licna" id="licna" />

        <br />
        <input type="submit" value="Pretraga" name="submit">
    </form>

    <?php
        function pretraga()
        {
            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";
            $licna = $_POST["licna"];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM vlasnik WHERE lična_karta = ?";

            $result = $conn->execute_query($sql, [$licna]);
            $row = $result->fetch_assoc();

            if((bool)$row) {

                forma($row);
            } else {

                echo 'NOT FOUND';
            }
        }

        if(isset($_POST['submit']))
        {
            pretraga();
        }

        function forma($row) {

            echo '<br><form action="uredi_vlasnika.php" method="post">

            <label for="licna">Broj lične karte</label>
            <input type="text" value="'.$row['lična_karta'].'" name="licna2" id="licna2" readonly/>

            <label for="ime">Ime</label>
            <input type="text" value="'.$row['ime'].'" name="ime" id="ime" />

            <label for="prezime">Prezime</label>
            <input type="text" value="'.$row['prezime'].'" name="prezime" id="prezime" />

            <label for="opcina">Općina</label>
            <input type="text" value="'.$row['općina'].'" name="opcina" id="opcina" />

            <label for="mjesto">Mjesto</label>
            <input type="text" value="'.$row['mjesto'].'" name="mjesto" id="mjesto" />

            <label for="adresa">Adresa</label>
            <input type="text" value="'.$row['adresa'].'"name="adresa" id="adresa" />

            <br />
            <input type="submit" value="Uredi" name="submit2">
            </form>';
        }

        function uredi(){

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $licna2 = $_POST["licna2"];
            $ime = $_POST["ime"];
            $prezime = $_POST["prezime"];
            $opcina = $_POST["opcina"];
            $mjesto = $_POST["mjesto"];
            $adresa = $_POST["adresa"];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "UPDATE vlasnik
                    SET ime = '$ime', prezime = '$prezime', općina = '$opcina', mjesto = '$mjesto', adresa = '$adresa'
                    WHERE lična_karta = '$licna2'";

            if (mysqli_query($conn, $sql)) {
                echo '<h2>Uređivanje vlasnika uspješno!</h2>';
                echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                    </form>';
              } else {

                echo '<h2>Greška u uređivanju!</h2> ' . mysqli_error($conn);
                echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                    </form>';
              }
        }

        if(isset($_POST['submit2']))
        {
            uredi();
        }
    ?>
</body>

</html>