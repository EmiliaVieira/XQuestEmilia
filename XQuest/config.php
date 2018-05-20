<?php

/**
 * Configuração para conexão com a base de dados
 *
 */

$host       = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "XQuest"; 
$dsn        = "mysql:host=$host;dbname=$dbname"; 
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );