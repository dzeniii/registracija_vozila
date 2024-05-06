<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Novi vlasnik</h1>
    <form action="dodaj_vlasnika.php" method="post">

        <label for="licna">Broj lične karte</label>
        <input type="text" name="licna" id="licna" />

        <label for="ime">Ime</label>
        <input type="text" name="ime" id="ime" />

        <label for="prezime">Prezime</label>
        <input type="text" name="prezime" id="prezime" />

        <label for="opcina">Općina</label>
        <input type="text" name="opcina" id="opcina" />

        <label for="mjesto">Mjesto</label>
        <input type="text" name="mjesto" id="mjesto" />

        <label for="adresa">Adresa</label>
        <input type="text" name="adresa" id="adresa" />

        <br />
        <input type="submit" value="Dodati" name="submit">
    </form>
    <?php
        function dodaj(){
            $licna = $_POST["licna"];
            $ime = $_POST["ime"];
            $prezime = $_POST["prezime"];
            $opcina = $_POST["opcina"];
            $mjesto = $_POST["mjesto"];
            $adresa = $_POST["adresa"];

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO vlasnik VALUES(?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                die(mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "ssssss", $licna, $ime, $prezime, $opcina, $mjesto, $adresa);

            mysqli_stmt_execute($stmt);

            echo '<h2>Dodavanje novog vlasnika uspješno!</h2>';
            echo '<form action="dbconnection.php">
                    <input type="submit" value="Nazad" />
                </form>';
        }

        if(isset($_POST['submit']))
        {
            dodaj();
        }
    ?>
</body>

</html>