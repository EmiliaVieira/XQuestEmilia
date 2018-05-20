<?php include "templates/header.php"; ?>

<?php
	try {	
		require "config.php";
		require "common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$sqlCliente = "SELECT ID, NAME
			           FROM CUSTOMERS";
		$statementCliente = $connection->prepare($sqlCliente);
		$statementCliente->execute();
		$resultCliente = $statementCliente->fetchAll();
		
		$sqlProduto = "SELECT ID, DESCRIPTION
			           FROM PRODUCTS";
		$statementProduto = $connection->prepare($sqlProduto);
		$statementProduto->execute();
		$resultProduto = $statementProduto->fetchAll();
		
		$sqlMarca = "SELECT ID, DESCRIPTION
			         FROM EQUIPMENTBRANDS";
		$statementMarca = $connection->prepare($sqlMarca);
		$statementMarca->execute();
		$resultMarca = $statementMarca->fetchAll();

        $sqlModelo = "SELECT ID, DESCRIPTION
		             FROM EQUIPMENTMODELS ";
		$statementModelo = $connection->prepare($sqlModelo);
		$statementModelo->execute();
		$resultModelo = $statementModelo->fetchAll();
		
		$sqlMemoria = "SELECT DISTINCT MEMORYAMOUNT
		             FROM EQUIPMENTS";
		$statementMemoria = $connection->prepare($sqlMemoria);
		$statementMemoria->execute();
		$resultMemoria = $statementMemoria->fetchAll();
		
		$sqlSO = "SELECT DISTINCT DESCRIPTION
		             FROM EQUIPMENTOS";
		$statementSO = $connection->prepare($sqlSO);
		$statementSO->execute();
		$resultSO = $statementSO->fetchAll();
		
		$sqlVSO = "SELECT DISTINCT ID, DESCRIPTION
		             FROM OSVERSIONS";
		$statementVSO = $connection->prepare($sqlVSO);
		$statementVSO->execute();
		$resultVSO = $statementVSO->fetchAll();

        $connection=null;
	} catch(PDOException $error) {
		echo $error->getMessage();
	}
?>

<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-body">
       <div class="row">
       <div class="col-sm-4">
	   <label>Agrupamento:</label>
	   </div>
	   <div class="col-sm-8">
	   <label>Filtros:</label>
	   </div>
       </div>
       <div class="row form-group">
       <div class="col-sm-2">
	   <input type="checkbox" id="agruCliente">Cliente<br>
	   </div>
	   <div class="col-sm-2">
	   <input type="checkbox" id="agruProduto">Produto<br>
	   </div>
	   <div class="col-sm-4">
	   <select class="selectpicker" name="cliente" id="cliente" title="Cliente" multiple > 
        <?php
        foreach ($resultCliente as $row) 
        {
          echo '<option value="'.$row['ID'].'"> '.$row['NAME'].' </option>';
        }
        ?>
		</select>
		</div>
		<div class="col-sm-4">
		<select class="selectpicker" name="memoria" id="memoria" title="Memória" multiple>
        <?php
        foreach ($resultMemoria as $row) 
        {
          echo '<option value="'.$row['MEMORYAMOUNT'].'"> '.$row['MEMORYAMOUNT'].' </option>';
        }
        ?>
        </select>
	   </div>
       </div>
	   <div class="row form-group">
       <div class="col-sm-2">
	   <input type="checkbox" id="agruMarca">Marca<br>
	   </div>
	   <div class="col-sm-2">
	   <input type="checkbox" id="agruModelo">Modelo<br>
	   </div>
	   <div class="col-sm-4">
	   <select class="selectpicker"  name="produto" id="produto" title="Produto" multiple>
        <?php
        foreach ($resultProduto as $row) 
        {
          echo '<option value="'.$row['ID'].'"> '.$row['DESCRIPTION'].' </option>';
        }
        ?>
        </select>
		</div>
		<div class="col-sm-4">
		<select class="selectpicker" name="marca" id="marca" title="Marca" multiple>
        <?php
        foreach ($resultMarca as $row) 
        {
          echo '<option value="'.$row['ID'].'"> '.$row['DESCRIPTION'].' </option>';
        }
        ?>
        </select>
	   </div>
       </div>
       <div class="row form-group">
       <div class="col-sm-2">
	   <input type="checkbox" id="agruMemoria">Memória<br>
	   </div>
	   <div class="col-sm-2">
	   <input type="checkbox" id="agruSO">SO<br>
	   </div>
	   <div class="col-sm-4">
	    <select class="selectpicker" name="modelo" id="modelo" title="Modelo" multiple>
        <?php
        foreach ($resultModelo as $row) 
        {
          echo '<option value="'.$row['ID'].'"> '.$row['DESCRIPTION'].' </option>';
        }
        ?>
        </select>
		</div>
		<div class="col-sm-4">
		<select class="selectpicker" name="so" id="so" title="SO" multiple>
        <?php
        foreach ($resultSO as $row) 
        {
          echo '<option value="'.$row['DESCRIPTION'].'"> '.$row['DESCRIPTION'].' </option>';
        }
        ?>
        </select>
	   </div>
       </div>
	   <div class="row form-group">
       <div class="col-sm-2">
	    <input type="checkbox" id="agruVersaoSO">Versão do SO<br>
	   </div>
	   <div class="col-sm-2">
	   </div>
	   <div class="col-sm-4">
	    <select class="selectpicker" name="vso" id="vso" title="Versão do SO" multiple>
        <?php
        foreach ($resultVSO as $row) 
        {
          echo '<option value="'.$row['ID'].'"> '.$row['DESCRIPTION'].' </option>';
        }
        ?>
        </select>
		</div>
		<div class="col-sm-4">
       </div>
	   </div>
	   
	   	   </br>
	   <div class="row">
       <div class="col-sm-4">
	   </div>
	   <div class="col-sm-4">
	   <label>Clientes:</label>
	   </div>
	   </div>
	   <div class="row">
       <div class="col-sm-4">
	   </div>
	   <div class="col-sm-8">
	   <div class="row">
	   <div class="col-sm-2">
	   <input type="radio" name="tipoCliente" id="todosClientes" value="" checked>Todos
	   </div>
	   <div class="col-sm-2">
	   <input type="radio" name="tipoCliente" id="apenasAtivos" value="1">Ativos
	   </div>
	   <div class="col-sm-2">
	   <input type="radio" name="tipoCliente" id="apenasInativos" value="0">Inativos
	   </div>
	   </div>
       </div>
	   </div>
	   </br>
	   
	   <div class="row">
       <div class="col-sm-8">
	   </div>
	   <div class="col-sm-3">
	   <button class="btn btn-default btn-md" type="button" id="filtrar" style="background-color:#4CAF50;" title="Filtrar">Filtrar</button>	
	   <button class="btn btn-default btn-md" type="button" id="limpar" style="background-color:#f44336;" title="Limpar" >Limpar</button>	
	   <button class="btn btn-default btn-md" type="button" id="exportar" style="background-color:#008CBA;" title="Exportar CSV">Exportar</button>	
	   </div>
	   <div class="col-sm-1">
	   </div>
       </div>
	   </div>
	   </div>  
	   <div id="txtGrid" ></div>
       <div id="txtMsg" style="text-align:center;"></div> 
	   </div>  
	   
	   <script src="scriptIndex.js"></script>
	   
<?php include "templates/footer.php"; ?>