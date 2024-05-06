<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Registracija vozila</h1>
    <form action="registracija_vozila.php" method="post">

        <label for="vozilo">Unesite JIB vozila</label>
        <input type="text" name="vozilo" id="vozilo" />

        <br />
        <input type="submit" value="Nastavi" name="submit">
    </form>
    <?php
        function postojanje_vozila(){

            $vozilo = $_POST["vozilo"];

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM vozilo WHERE vozilo_id = ?";

            $result = $conn->execute_query($sql, [$vozilo]);
            $row = $result->fetch_assoc();

            if((bool)$row) { //vozilo postoji

                $sql = "SELECT * FROM registracija WHERE vozilo = ?";

                $result = $conn->execute_query($sql, [$vozilo]);
                $row = $result->fetch_assoc();

                if((bool)$row) { //postoji registracija

                    $curdate = date('Y-m-d', time());
                    if($row['rok_trajanja'] > $curdate) { //vazeca registracija

                        echo '<h2>Registracija je validna!</h2>';
                        echo '<form action="dbconnection.php">
                                <input type="submit" value="Nazad"/>
                                </form>';
                    } else { //registracija istekla

                        provjera_osiguranja($vozilo);
                    }

                } else { //registracija ne postoji

                    provjera_osiguranja($vozilo);
                }

            } else { //vozilo ne postoji

                echo 'NOT FOUND';
            }
        }

        function provjera_osiguranja($vozilo) {

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM osiguranje WHERE vozilo = ?";

            $result = $conn->execute_query($sql, [$vozilo]);
            $row = $result->fetch_assoc();

            if((bool)$row) { //osiguranje postoji

                $curdate = date('Y-m-d', time());
                
                if($row['rok_trajanja'] > $curdate) { //vazece osiguranje

                    registracija_forma($vozilo);

                } else { //osiguranje nije vazece

                    produzenje_osiguranja($vozilo);
                }

            } else { //osiguranje ne postoji

                dodaj_osiguranje_forma($vozilo);
            }
        }

        function dodaj_osiguranje_forma($vozilo) {

            echo '<form action="registracija_vozila.php" method="post">

                <label for="broj_police">Broj police osiguranja</label>
                <input type="text" name="broj_police" id="broj_police" />

                <label for="drustvo">Osiguravajuće društvo</label>
                <input type="text" name="drustvo" id="drustvo" />

                <label for="vozilo">JIB vozila</label>
                <input type="text" value="'.$vozilo.'" name="vozilo" id="vozilo" readonly/>

                <label for="premija">Premija osiguranja</label>
                <input type="text" name="premija" id="premija" />

                <label for="rok_trajanja">Datum isteka</label>
                <input type="text" name="rok_trajanja" id="rok_trajanja" />

                <label for="suma">Suma osiguranja</label>
                <input type="text" name="suma" id="suma" />

                <br />
                <input type="submit" value="Dodati" name="submit2">
            </form>';
        }

        function dodaj_osiguranje() {

            $vozilo = $_POST['vozilo'];
            $broj_police = $_POST['broj_police'];
            $drustvo = $_POST['drustvo'];
            $premija = $_POST['premija'];
            $rok_trajanja = $_POST['rok_trajanja'];
            $suma = $_POST['suma'];

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO osiguranje VALUES(?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                die(mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "isidsd", $broj_police, $drustvo, $vozilo, $premija, $rok_trajanja, $suma);

            mysqli_stmt_execute($stmt);

            echo '<h2>Uspješno osigurato vozilo!</h2>';
            echo '<form action="dbconnection.php">
                    <input type="submit" value="Nazad" />
                </form>';
        }

        function registracija_forma($vozilo) {

            echo '<form action="registracija_vozila.php" method="post">

                <label for="reg_oznaka">Registarska oznaka vozila</label>
                <input type="text" name="reg_oznaka" id="reg_oznaka" />

                <label for="datum_izd">Datum izdavanja</label>
                <input type="text" name="datum_izd" id="datum_izd" />

                <label for="mjesto_izd">Mjesto izdavanja</label>
                <input type="text" name="mjesto_izd" id="mjesto_izd" />

                <label for="vozilo">JIB vozila</label>
                <input type="text" value="'.$vozilo.'" name="vozilo" id="vozilo" readonly/>                

                <label for="rok_trajanja">Datum isteka</label>
                <input type="text" name="rok_trajanja" id="rok_trajanja" />

                <br />
                <input type="submit" value="Dodati" name="submit3">
            </form>';
        }

        function registracija_vozila() {

            $vozilo = $_POST['vozilo'];
            $reg_oznaka = $_POST['reg_oznaka'];
            $datum_izd = $_POST['datum_izd'];
            $mjesto_izd = $_POST['mjesto_izd'];
            $rok_trajanja = $_POST['rok_trajanja'];

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO registracija VALUES(?, ?, ?, ?, ?)";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                die(mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "sssis", $reg_oznaka, $datum_izd, $mjesto_izd, $vozilo, $rok_trajanja);

            mysqli_stmt_execute($stmt);

            echo '<h2>Vozilo uspješno registrovano!</h2>';
            echo '<form action="dbconnection.php">
                    <input type="submit" value="Nazad" />
                </form>';
        }

        function produzenje_osiguranja($vozilo) {

            $vozilo = $_POST['vozilo'];

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "UPDATE osiguranje
                    SET rok_trajanja = DATE_ADD(rok_trajanja, INTERVAL 1 YEAR)
                    WHERE vozilo = '$vozilo'";

            if (mysqli_query($conn, $sql)) {
                echo '<h2>Osiguranje produženo!</h2>';
                echo '<form action="registracija_vozila.php">
                        <input type="submit" value="Registruj vozilo" name="submit4"/>
                    </form>';
            } else {

                echo '<h2>Greška u produženju osiguranja!</h2> ' . mysqli_error($conn);
                echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                    </form>';
            }
        }

        if(isset($_POST['submit4']))
        {
            registracija_vozila();
        }

        if(isset($_POST['submit3']))
        {
            registracija_vozila();
        }

        if(isset($_POST['submit2']))
        {
            dodaj_osiguranje();
        }

        if(isset($_POST['submit']))
        {
            postojanje_vozila();
        }
    ?>
</body>

</html>