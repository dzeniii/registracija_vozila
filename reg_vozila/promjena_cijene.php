<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Promjena cijene kategorije vozila</h1>
    <form action="promjena_cijene.php" method="post">

        <label for="vozilo">Unesite kategoriju vozila</label>
        <select name="kategorija" id="kategorija">
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
                
                while($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                
                    echo '<option value="'.$row['kategorija'].'">'.$row['kategorija'].' - '.$row['naziv_kategorije'].'</option>';
                }
            ?>
            </select>

        <br />
        <input type="submit" value="Promijeni cijenu" name="submit">
    </form>

    <?php
        function pretraga()
        {
            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";
            $kategorija = $_POST["kategorija"];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM kategorija WHERE kategorija = ?";

            $result = $conn->execute_query($sql, [$kategorija]);
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

            echo '<br><form action="promjena_cijene.php" method="post">

            <label for="stara_cijena">Trenutna cijena</label>
            <input type="text" value="'.$row['cijena_tehničkog'].'" name="stara_cijena" id="stara_cijena" readonly/>

            <label for="kategorija">Kategorija</label>
            <input type="text" value="'.$row['kategorija'].'" name="kategorija" id="kategorija" readonly>

            <label for="nova_cijena">Nova cijena</label>
            <input type="text" name="nova_cijena" id="nova_cijena" />

            <br />
            <input type="submit" value="Promjeni" name="submit2">
            </form>';
        }

        function promjeni(){

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";
        
            $kategorija = $_POST["kategorija"];
            $nova_cijena = $_POST["nova_cijena"];

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "UPDATE kategorija
                    SET cijena_tehničkog = '$nova_cijena'
                    WHERE kategorija = '$kategorija'";

            if (mysqli_query($conn, $sql)) {
                echo '<h2>Promjena cijene kategorije vozila uspješna!</h2>';
                echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                    </form>';
              } else {

                echo '<h2>Greška u promjeni cijene kategorije vozila!</h2> ' . mysqli_error($conn);
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