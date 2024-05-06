<!DOCTYPE html>
<html>

<head>
    <title>Provjera registracije vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <form action="provjera_osiguranja.php" method="post">

        <label for="vozilo">Unesite JIB vozila</label>
        <input type="text" name="vozilo" id="vozilo" />

        <br />
        <input type="submit" value="Provjeri" name="submit">
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

                $sql = "SELECT * FROM osiguranje WHERE vozilo = ?";

                    $result = $conn->execute_query($sql, [$vozilo]);
                    $row = $result->fetch_assoc();

                if((bool)$row) { //postoji osiguranje

                    $curdate = date('Y-m-d', time());
                    if($row['rok_trajanja'] > $curdate) { //vazece osiguranje

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

                        echo '<table><thead><tr>
                            <th>Broj police</th>
                            <th>Osiguravajuće društvo</th>
                            <th>JIB vozila</th>
                            <th>Premija osiguranja</th>
                            <th>Rok trajanja</th>
                            <th>Suma osiguranja</th>
                            </tr></thead>';

                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>'.$row['broj_police'].'</td>';
                        echo '<td>'.$row['društvo'].'</td>';
                        echo '<td>'.$row['vozilo'].'</td>';
                        echo '<td>'.$row['premija'].'</td>';
                        echo '<td>'.$row['rok_trajanja'].'</td>';
                        echo '<td>'.$row['suma'].'</td>';
                        echo '</tr></tbody></table>';

                        echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                        </form>';
                    } else { //osiguranje isteklo

                        echo '<h2>Osiguranje nije važeće</h2>';
                        echo '<form action="dbconnection.php">
                                <input type="submit" value="Nazad" />
                                </form>';
                    }

                } else { //osiguranje ne postoji

                    echo '<h2>Vozilo nije osigurano</h2>';
                    echo '<form action="dbconnection.php">
                            <input type="submit" value="Nazad" />
                            </form>';
                }
            } else {

            echo '<h2>Vozilo ne postoji!</h2>';
                    echo '<form action="dbconnection.php">
                            <input type="submit" value="Nazad" />
                            </form>';
            }
        }

        if(isset($_POST['submit']))
        {
            pretraga();
        }
    ?>
</body>

</html>