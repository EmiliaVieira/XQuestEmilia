<?php
$obj = json_decode($_GET["x"], false);
	try {	
		require "config.php";
		require "common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$campos = "";
		$agrupamentos = "";
		$priAgru = true;
        if ($obj->agruCli)
			{
				$campos = $campos . "CUSTOMERS.NAME AS NOMECLI ";
                $agrupamentos =  $agrupamentos . " CUSTOMERS.ID ";
				$priAgru = false;
			}
			if ($obj->agruPro)
			{
				if ($priAgru)
				{
                   $campos = $campos . " PRODUCTS.DESCRIPTION AS NOMEPRO ";
				   $agrupamentos =  $agrupamentos . " PRODUCTS.ID ";
				   $priAgru = false;
				}
				else
				{
					$campos = $campos . ", PRODUCTS.DESCRIPTION AS NOMEPRO ";
					$agrupamentos =  $agrupamentos . ", PRODUCTS.ID ";
				}
			}
			if ($obj->agruMar)
			{
				if ($priAgru)
				{
				   $campos = $campos . " EQUIPMENTBRANDS.DESCRIPTION AS NOMEMARCA ";
				   $agrupamentos =  $agrupamentos . " EQUIPMENTBRANDS.ID ";
				   $priAgru = false;
				}
				else
				{
					$campos = $campos . ", EQUIPMENTBRANDS.DESCRIPTION AS NOMEMARCA ";
					$agrupamentos =  $agrupamentos . ", EQUIPMENTBRANDS.ID ";
				}
			}
			if ($obj->agruMod)
			{
				if ($priAgru)
				{
				   $campos = $campos . " EQUIPMENTMODELS.DESCRIPTION AS NOMEMODELO ";
				   $agrupamentos =  $agrupamentos . " EQUIPMENTMODELS.ID ";
				   $priAgru = false;
				}
				else
				{
					$campos = $campos . ", EQUIPMENTMODELS.DESCRIPTION AS NOMEMODELO ";
					$agrupamentos =  $agrupamentos . ", EQUIPMENTMODELS.ID ";
				}
			}
			if ($obj->agruMem)
			{
				if ($priAgru)
				{
				   $campos = $campos . " EQUIPMENTS.MEMORYAMOUNT ";
				   $agrupamentos =  $agrupamentos . " EQUIPMENTS.MEMORYAMOUNT ";
				   $priAgru = false;
				}
				else
				{
					$campos = $campos . ", EQUIPMENTS.MEMORYAMOUNT ";
					$agrupamentos =  $agrupamentos . ", EQUIPMENTS.MEMORYAMOUNT ";
				}
			}
			if ($obj->agruSO)
			{
				if ($priAgru)
				{
				   $campos = $campos . " EQUIPMENTOS.DESCRIPTION AS NOMEOS ";
				   $agrupamentos =  $agrupamentos . " EQUIPMENTOS.DESCRIPTION ";
				   $priAgru = false;	   
				}
				else
				{
					$campos = $campos . ", EQUIPMENTOS.DESCRIPTION AS NOMEOS ";
					$agrupamentos =  $agrupamentos . ", EQUIPMENTOS.ID ";
				}
			}
			if ($obj->agruVSO)
			{
				if ($priAgru)
				{
				   $campos = $campos . " OSVERSIONS.DESCRIPTION AS NOMEVOS ";
				   $agrupamentos =  $agrupamentos . " OSVERSIONS.ID ";
				   $priAgru = false;	
				}
				else
				{
					$campos = $campos . ", OSVERSIONS.DESCRIPTION AS NOMEVOS ";
					$agrupamentos =  $agrupamentos . ", OSVERSIONS.ID ";
				}
			}
									  
		$sql = "SELECT " . $campos . "
					   , COUNT(1) AS QTD
			    FROM EQUIPMENTCOLLECTED, LICENSE, EQUIPMENTS, CUSTOMERS, PRODUCTS, EQUIPMENTBRANDS, EQUIPMENTMODELS, EQUIPMENTOS, OSVERSIONS
			    WHERE EQUIPMENTCOLLECTED.LICENSEID = LICENSE.ID
				      AND EQUIPMENTCOLLECTED.EQUIPMENTID = EQUIPMENTS.ID
				      AND LICENSE.CUSTOMERID = CUSTOMERS.ID
                      AND LICENSE.PRODUCTID = PRODUCTS.ID 
					  AND EQUIPMENTS.BRANDID = EQUIPMENTBRANDS.ID
					  AND EQUIPMENTS.MODELID = EQUIPMENTMODELS.ID
					  AND EQUIPMENTS.OSID = EQUIPMENTOS.ID
					  AND EQUIPMENTOS.OSID = OSVERSIONS.ID
					  AND EQUIPMENTCOLLECTED.DTCOL = (SELECT MAX(DTCOL) FROM EQUIPMENTCOLLECTED EQ WHERE EQ.LICENSEID = LICENSE.ID)"; 
				
        if ($obj->tipoCliente != "")				
			$sql =  $sql . " AND LICENSE.ACTIVE = '" . $obj->tipoCliente . "' ";
					  
		if ($obj->cliente != "")
            $sql =  $sql . " AND CUSTOMERS.ID IN (" . $obj->cliente . ")";
		
		if ($obj->produto != "")
            $sql =  $sql . " AND PRODUCTS.ID IN (" . $obj->produto . ")";
				  
        if ($obj->marca != "")
            $sql =  $sql . " AND EQUIPMENTBRANDS.ID IN (" . $obj->marca . ")";
                  
        if ($obj->modelo != "")
            $sql =  $sql . " AND EQUIPMENTMODELS.ID IN (" . $obj->modelo . ")";
		
		if ($obj->memoria != "")
            $sql =  $sql . " AND EQUIPMENTS.MEMORYAMOUNT IN (" . $obj->memoria . ")";
		
		if ($obj->so != "")
            $sql =  $sql . " AND EQUIPMENTOS.DESCRIPTION IN (" . $obj->so . ")";
		
		if ($obj->vso != "")
            $sql =  $sql . " AND OSVERSIONS.ID IN (" . $obj->vso . ")";

		 $sql =  $sql . " GROUP BY " . $agrupamentos ;

		$statement = $connection->prepare($sql);
		$statement->execute();

		$result = $statement->fetchAll();
        $connection=null;
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}

	$total = 0;
	foreach ($result as $row)
	 $total += $row["QTD"];

echo "
<table id=\"aparelhos\">
<thead>
 <tr>" ;
 if ($obj->agruCli)
   echo " <th>Cliente</th> ";
if ($obj->agruPro)
   echo " <th>Produto</th> ";
if ($obj->agruMar)
   echo " <th>Marca</th> ";
if ($obj->agruMod)
  echo " <th>Modelo</th> " ;
if ($obj->agruMem)
  echo " <th>Memória</th> ";
if ($obj->agruSO)
  echo " <th>SO</th> ";
if ($obj->agruVSO)	
   echo " <th>Versão</th> ";
echo
 " <th>Quantidade</th>
  <th>%/Total</th>
  </tr>
</thead>
<tbody>";
foreach ($result as $row){
echo "<tr>";
if ($obj->agruCli)
   echo "<td>" . $row["NOMECLI"] . "</td>";
if ($obj->agruPro)
   echo "<td>" . $row["NOMEPRO"]. "</td>";
if ($obj->agruMar)
   echo "<td>" . $row["NOMEMARCA"] . "</td>";
if ($obj->agruMod)
  echo "<td>" . $row["NOMEMODELO"] . "</td>";
if ($obj->agruMem)
  echo "<td>" . $row["MEMORYAMOUNT"] . "</td>";
if ($obj->agruSO)
  echo "<td>" . $row["NOMEOS"] . "</td>";
if ($obj->agruVSO)	
   echo "<td>" . $row["NOMEVOS"] . "</td>";
echo "<td>" . $row["QTD"] . "</td>";
echo "<td>" . round(($row["QTD"] * 100) / $total, 2) . "%</td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";

?>
