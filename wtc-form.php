<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <title>WTC Anmeldung</title>
</head>

<?php
//diverse Variablen initiieren:
$msg = $fields = $vorname = $nachname = $email = $firma = "";
$msgClass = "text-danger";
//Wenn abgesendet wird...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //...dann vorhandene Einträge zwischenspeichern.
    $vorname = test_input($_POST["vorname"]);
    $nachname = test_input($_POST["nachname"]);
    $email = test_input($_POST["email"]);
    $firma = test_input($_POST["firma"]);
    //Wenn alles ausgefüllt wurde...
    if (
        !empty($_POST["vorname"])
        && !empty($_POST["nachname"])
        && !empty($_POST["email"])
        && !empty($_POST["firma"])
    ) {
        require_once("config.php");
        //...prüfen, ob E-Mail schon in Datenbank...
        $duplicate = mysqli_query($conn, "select * from wtc_teilnehmer where email='$email'");
        if (mysqli_num_rows($duplicate) > 0) {
            $msgClass = "text-danger";
            $msg = "Ein Teilnehmer mit dieser E-Mail-Adresse existiert bereits!";
        } else { //...ansonsten senden.
            $sql = "INSERT INTO wtc_teilnehmer (vorname, nachname, email, firma) VALUES ('$vorname', '$nachname', '$email', '$firma')";
            if (!$result = $conn->query($sql)) {
                die('There was an error running the query [' . $conn->error . ']');
            } else {
                $msgClass = "text-success";
                $msg = "Sie haben sich erfolgreich angemeldet!";
                $fields = "disabled"; //disabled die Input-Felder nach dem Versenden. 
            }
        }
        //...wenn nicht alles ausgefüllt wurde Hinweis anzeigen.
    } else {
        if (empty($_POST["vorname"])
        || empty($_POST["nachname"])
        || empty($_POST["email"])
        || empty($_POST["firma"])) {
            $msg = "Bitte füllen Sie das Formular vollständig aus!";
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<body class="bg-dark container">
    <div class="row">
        <div class="col-3"></div>
        <div class="bg-light rounded col-6 mt-5">
            <h1>WTC-Anmeldung</h1>
            <p>Hier können Sie sich für die Konferenz anmelden:</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="vorname" id="floatingInput" value="<?php echo $vorname; ?>" placeholder="Vorname" <?php echo $fields; ?>>
                    <label for="floatingInput" class="text-muted">Vorname</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="nachname" id="floatingInput" value="<?php echo $nachname; ?>" placeholder="Nachname" <?php echo $fields; ?>>
                    <label for="floatingInput" class="text-muted">Nachname</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="email" id="floatingInput" value="<?php echo $email; ?>" placeholder="E-Mail" <?php echo $fields; ?>>
                    <label for="floatingInput" class="text-muted">E-Mail</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="firma" id="floatingInput" value="<?php echo $firma; ?>" placeholder="Firma" <?php echo $fields; ?>>
                    <label for="floatingInput" class="text-muted">Firma</label>
                </div>
                <div class=>
                    <input class="mb-3 btn btn-success" type="submit" name="submit" value="anmelden" <?php echo $fields; ?>>
                </div>
            </form>
            <p><span class="<?php echo $msgClass; ?>"><?php echo $msg; ?></span></p>
        </div>
        <div class="col-3"></div>
    </div>
</body>

</html>