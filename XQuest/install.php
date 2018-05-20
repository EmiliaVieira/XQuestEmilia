<?php

/**
 * Abre a conexão via PDO para criar a
 * nova base de dados.
 *
 */

require "config.php";

try {
	$connection = new PDO("mysql:host=$host", $username, $password, $options);
	$sql = file_get_contents("data/init.sql");
	$connection->exec($sql);
	
	echo "Base de dados criada e populada com sucesso!!!";
} catch(PDOException $error) {
	echo $sql . "<br>" . $error->getMessage();
}