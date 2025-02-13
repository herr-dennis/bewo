<?php

$host = "localhost";  // oder die IP-Adresse des Servers
$dbname = "bewodb";
$user = "root";
$pass = "ihesp";

try {
    // Verbindung mit der MySQL-Datenbank herstellen
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Verbindung erfolgreich!<br>";

    // Benutzerdaten
    $name = "Admin";
    $pw_nativ = "sicher";
    $salt = "$2y$10$";
    $pw_hash = hash("sha256", $pw_nativ . $salt);

    // SQL-Query vorbereiten
    $sql = "INSERT INTO admins (user_name, pw, salt) VALUES (:name, :pw, :salt)";
    $stmt = $pdo->prepare($sql);

    // Parameter binden und ausführen
    $stmt->execute([
        ":name" => $name,
        ":pw" => $pw_hash,
        ":salt" => $salt
    ]);

    echo "Admin erfolgreich eingefügt!";
} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}
