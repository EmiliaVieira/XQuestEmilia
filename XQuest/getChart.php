<?php
	try {	
		require "config.php";
		require "common.php";

		$connection = new PDO($dsn, $username, $password, $options);
				
		$sql = "SELECT OSVERSIONS.DESCRIPTION,
					   COUNT(1) AS QTD
			    FROM EQUIPMENTCOLLECTED, LICENSE, EQUIPMENTS, EQUIPMENTOS, OSVERSIONS
			    WHERE EQUIPMENTCOLLECTED.LICENSEID = LICENSE.ID
				      AND EQUIPMENTCOLLECTED.EQUIPMENTID = EQUIPMENTS.ID
				      AND EQUIPMENTS.OSID = EQUIPMENTOS.ID
					  AND EQUIPMENTOS.OSID = OSVERSIONS.ID
					  AND DTCOL = (SELECT MAX(DTCOL) FROM EQUIPMENTCOLLECTED EQ WHERE EQ.LICENSEID = EQUIPMENTCOLLECTED.LICENSEID)
					  AND LICENSE.ACTIVE = '1'
				GROUP BY OSVERSIONS.ID ";		

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
echo "<td class=\"versao\">" . $row["DESCRIPTION"] . "</td>";
echo "<td class=\"quantidade\">" . $row["QTD"] . "</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";

?>
