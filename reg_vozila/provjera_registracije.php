<!DOCTYPE html>
<html>

<head>
    <title>Provjera registracije vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <form action="provjera_registracije.php" method="post">

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

                $sql = "SELECT * FROM registracija WHERE vozilo = ?";

                    $result = $conn->execute_query($sql, [$vozilo]);
                    $row = $result->fetch_assoc();

                if((bool)$row) { //postoji registracija

                    $curdate = date('Y-m-d', time());
                    if($row['rok_trajanja'] > $curdate) { //vazeca registracija

                        $host = "localhost:3306";
                        $username = "root";
                        $password = "1234";
                        $dbname = "reg_vozila";

                        $conn = mysqli_connect($host, $username, $password, $dbname);

                        if(!$conn) {

                            die("Connection error: " . mysqli_connect_error());
                        }

                        $sql = "SELECT * FROM registracija WHERE vozilo = ?";

                        $result = $conn->execute_query($sql, [$vozilo]);
                        $row = $result->fetch_assoc();

                        echo '<table><thead><tr>
                            <th>Registarska oznaka</th>
                            <th>Datum izdavanja</th>
                            <th>Mjesto izdavanja</th>
                            <th>JIB vozila</th>
                            <th>Rok trajanja</th>
                            </tr></thead>';

                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>'.$row['registarska_oznaka'].'</td>';
                        echo '<td>'.$row['datum_izdavanja'].'</td>';
                        echo '<td>'.$row['mjesto_izdavanja'].'</td>';
                        echo '<td>'.$row['vozilo'].'</td>';
                        echo '<td>'.$row['rok_trajanja'].'</td>';
                        echo '</tr></tbody></table>';

                        echo '<form action="dbconnection.php">
                        <input type="submit" value="Nazad" />
                        </form>';
                    } else { //registracija istekla

                        echo '<h2>Registracija nije važeća</h2>';
                        echo '<form action="dbconnection.php">
                                <input type="submit" value="Nazad" />
                                </form>';
                    }

                } else { //registracija ne postoji

                    echo '<h2>Vozilo nije registrovano</h2>';
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