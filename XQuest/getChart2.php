<?php
	try {	
		require "config.php";
		require "common.php";

		$connection = new PDO($dsn, $username, $password, $options);
				
		$sql = "SELECT DATASDIF.DTCOL,
		               DATASDIF.DTFORMATADA,
                       VERSOESDIF.NOMEVERSAO,
                       (SELECT COUNT(1) 
					    FROM EQUIPMENTCOLLECTED, EQUIPMENTS, EQUIPMENTOS 
                        WHERE EQUIPMENTCOLLECTED.EQUIPMENTID = EQUIPMENTS.ID 
					          AND EQUIPMENTS.OSID = EQUIPMENTOS.ID    
					          AND EQUIPMENTOS.OSID = VERSOESDIF.ID
                              AND DTCOL = DATASDIF.DTCOL ) AS QTD
                FROM (SELECT DISTINCT DTCOL, DATE_FORMAT(DTCOL,'%d/%m/%Y') AS DTFORMATADA FROM EQUIPMENTCOLLECTED) AS DATASDIF,
                     (SELECT DISTINCT OSVERSIONS.ID, OSVERSIONS.DESCRIPTION AS NOMEVERSAO FROM OSVERSIONS) AS VERSOESDIF
                GROUP BY DATASDIF.DTCOL, VERSOESDIF.NOMEVERSAO
                ORDER BY DATASDIF.DTCOL" ;
					  
		$statement = $connection->prepare($sql);
		$statement->execute();

		$result = $statement->fetchAll();
                $connection=null;
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}


echo "
<table id=\"grafico1\">";
echo "<tbody>";
foreach ($result as $row){
echo "<tr>";
echo "<td class=\"data\">" . $row["DTFORMATADA"] . "</td>";
echo "<td class=\"versao\">" . $row["NOMEVERSAO"] . "</td>";
echo "<td class=\"quantidade_" . str_replace(".", "_", $row["NOMEVERSAO"]) . "\">" . $row["QTD"] . "</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";

?>
