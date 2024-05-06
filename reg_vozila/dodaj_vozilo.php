<!DOCTYPE html>
<html>

<head>
    <title>Registracija vozila</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <h1>Novo vozilo</h1>
    <form action="dodaj_vozilo.php" method="post">

    <table>
    <tbody>
        <tr>

            <td><label for="ime">Marka</label>
            <input type="text" name="marka" id="marka" /></td>

            <td><label for="prezime">Tip</label>
            <input type="text" name="tip" id="tip" /></td>

            <td><label for="opcina">Model</label>
            <input type="text" name="model" id="model" /></td>

        </tr>
        <tr style="background: #202b38">

            <td><label for="mjesto">Broj šasije</label>
            <input type="text" name="br_sasije" id="br_sasije" /></td>

            <td><label for="adresa">Masa</label>
            <input type="text" name="masa" id="masa" /></td>

            <td><label for="adresa">Zapremina</label>
            <input type="text" name="zapremina" id="zapremina" /></td>

        </tr>
        <tr>
            <td><label for="adresa">Snaga</label>
            <input type="text" name="snaga" id="snaga" /></td>

            <td><label for="adresa">Gorivo</label>
            <input type="text" name="gorivo" id="gorivo" /></td>

            <td><label for="adresa">Godište</label>
            <input type="text" name="godiste" id="godiste" /></td>
        </tr>
        <tr style="background: #202b38">
            <td><label for="adresa">Boja</label>
            <input type="text" name="boja" id="boja" /></td>
        
            <td><label for="kategorija">Kategorija</label>
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
            </select></td>

            <td><label for="adresa">Lična karta vlasnika</label>
            <input type="text" name="lc_karta" id="lc_karta" /></td>
        </tr>
    </tbody>
    </table>
    <br />
    <input type="submit" value="Dodati" name="submit">
    </form>
    <?php
        function dodaj(){
            $marka = $_POST["marka"];
            $tip = $_POST["tip"];
            $model = $_POST["model"];
            $br_sasije = $_POST["br_sasije"];
            $masa = $_POST["masa"];
            $zapremina = $_POST["zapremina"];
            $snaga = $_POST["snaga"];
            $gorivo = $_POST["gorivo"];
            $godiste = $_POST["godiste"];
            $boja = $_POST["boja"];
            $kategorija = $_POST["kategorija"];
            $licna = $_POST["lc_karta"];

            $host = "localhost:3306";
            $username = "root";
            $password = "1234";
            $dbname = "reg_vozila";

            $conn = mysqli_connect($host, $username, $password, $dbname);

            if(!$conn) {

                die("Connection error: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO vozilo(marka, tip, model, broj_šasije, masa, zapremina, snaga, gorivo, godište, boja, kategorija, vlasnik)
                     VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                die(mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "ssssddisssss", $marka, $tip, $model, $br_sasije, $masa, $zapremina, $snaga, $gorivo, $godiste,
                                    $boja, $kategorija, $licna);

            mysqli_stmt_execute($stmt);

            echo '<h2>Dodavanje novog vozila uspješno!</h2>';
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

