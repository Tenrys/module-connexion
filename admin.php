<?php
    session_start();

    if (!isset($_SESSION["user"]) || $_SESSION["user"]["login"] != "admin") {
        header("Refresh: 0; URL=/");
        die;
    }

    $users;

    $db = new mysqli("localhost", "root", "", "moduleconnexion");

    try {
        $request = "SELECT * FROM utilisateurs ORDER BY id ASC;";
        $query = $db->query($request);
        $users = $query->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $e) {
        echo "Exception reçue: {$e->getMessage()}";
        die;
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Admin</title>
    </head>

    <body>
        <header>
            <h1>Module Connexion</h1>
            <a href="index.php">Retour</a>
        </header>
        <main id="admin">
            <h2>Admin</h2>
            <table>
                <thead>
                    <tr>
                    <?php
                        foreach ($users[0] as $key => $value) {
                            ?>
                                <th><?= $key ?></th>
                            <?php
                        }
                    ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($users as $id => $row) {
                        ?>
                        <tr>
                        <?php
                            foreach ($row as $value) {
                                ?>
                                <td><?= $value ?></td>
                                <?php
                            }
                        ?>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </main>
    </body>
</html>