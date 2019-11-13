<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        header("Refresh: 0; URL=/");
        die;
    }

    extract($_SESSION["user"]);

    if (count($_POST) > 0) {
        extract($_POST);

        $db = new mysqli("localhost", "root", "", "moduleconnexion");

        try {
            $request = "UPDATE utilisateurs SET prenom = ?, nom = ? WHERE login = ?;";
            $stmt = $db->prepare($request);
            $stmt->bind_param("sss", $prenom, $nom, $login);
            $success = $stmt->execute();

            if ($success) {
                $_SESSION["user"]["prenom"] = $prenom;
                $_SESSION["user"]["nom"] = $nom;
            }
        } catch (Exception $e) {
            echo "Exception reçue: {$e->getMessage()}";
            die;
        }
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Profil</title>
    </head>

    <body>
        <header>
            <h1>Module Connexion</h1>
            <a href="index.php">Retour</a>
        </header>
        <main id="profil">
            <h2>Profil</h2>
            <?php
            if (isset($error)) {
                echo "<h4 style='color: red; font-weight: bold;'>$error</h4>";
            }
            if (isset($success) && $success) {
                echo "<h4 style='color: green; font-weight: bold;'>Modifications enregistrées avec  succès !</h4>";
            }
            ?>
            <form method="post">
                <div class="columns">
                    <div class="column">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" required minlength="3" maxlength="255" value="<?= $prenom ?? '' ?>">
                    </div>
                    <div class="column">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" required minlength="3" maxlength="255" value="<?= $nom ?? '' ?>">
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <input type="submit" value="Enregistrer">
                    </div>
                </div>
            </form>
        </main>
    </body>
</html>