<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Promjena vlasništva vozila</h1>
    <form action="promjena_vlasnistva.php" method="post">

        <label for="vozilo">Unesite JIB vozila</label>
        <input type="text" name="vozilo" id="vozilo" />

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
            $vozilo = $_POST["vozilo"];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM vozilo WHERE vozilo_id = ?";

            $result = $conn->execute_query($sql, [$vozilo]);
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

            echo '<br><form action="promjena_vlasnistva.php" method="post">

            <label for="vlasnik2">Trenutni vlasnik</label>
            <input type="text" value="'.$row['vlasnik'].'" name="vlasnik2" id="vlasnik2" readonly/>

            <label for="vozilo">Jedinstveni identifikacioni broj vozila</label>
            <input type="text" value="'.$row['vozilo_id'].'" name="vozilo" id="vozilo" />

            <label for="novi_vlasnik">Novi vlasnik</label>
            <input type="text" name="novi_vlasnik" id="novi_vlasnik" />

            <br />
            <input type="submit" value="Promjeni" name="submit2">
            </form>';
        }

        function promjeni(){

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $vlasnik2 = $_POST["vlasnik2"];
            $vozilo = $_POST["vozilo"];
            $novi_vlasnik = $_POST["novi_vlasnik"];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "UPDATE vozilo
                    SET vlasnik = '$novi_vlasnik'
                    WHERE vozilo_id = '$vozilo'";

            if (mysqli_query($conn, $sql)) {
                echo '<h2>Promjena vlasništva vozila uspješna!</h2>';
                echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                    </form>';
              } else {

                echo '<h2>Greška u promjeni vlasništva!</h2> ' . mysqli_error($conn);
                echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                    </form>';
              }
        }

        if(isset($_POST['submit2']))
        {
            promjeni();
        }
    ?>
</body>

</html>