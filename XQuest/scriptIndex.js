$(function () {
// Seta a aba corrente como sendo a da tabela	
$("#tabela").addClass("current");
$("#grafico1").removeClass("current");
$("#grafico2").removeClass("current");
getSessionFilters();

    $("#filtrar").click(function() {
       Filtrar();
    });
    
    $("#limpar").click(function () {
       Limpar();
    });
	
	$("#exportar").click(function () {
       Exportar();
    });
});

// Armazena os filtros selecionados
function setSessionFilters() {
    if (sessionStorage)
	{
		var tipoCli = "";
        if (document.getElementById("apenasAtivos").checked)
	        tipoCli = "1";
        else if (document.getElementById("apenasInativos").checked)
	    tipoCli = "0";
		var filter = {agruCli: document.getElementById("agruCliente").checked, 
                      agruPro: document.getElementById("agruProduto").checked, 
                      agruMar: document.getElementById("agruMarca").checked, 
                      agruMod: document.getElementById("agruModelo").checked, 
                      agruMem: document.getElementById("agruMemoria").checked, 
                      agruSO: document.getElementById("agruSO").checked, 
                      agruVSO: document.getElementById("agruVersaoSO").checked, 
		              cliente: Selecionados(document.getElementById("cliente"), false),
		              produto: Selecionados(document.getElementById("produto"), false),
                      marca: Selecionados(document.getElementById("marca"), false), 
                      modelo: Selecionados(document.getElementById("modelo"), false),
		              memoria: Selecionados(document.getElementById("memoria"), false),
		              so: Selecionados(document.getElementById("so"), false),
		              vso: Selecionados(document.getElementById("vso"), false),
                      tipoCliente : tipoCli };
        sessionStorage.setItem("last_filter",JSON.stringify(filter));
	}
}

// Recupera os últimos filtros selecionados
function getSessionFilters() {
    if (sessionStorage) {
        var filter = sessionStorage.getItem("last_filter");
        if (filter)
		{
           filter = JSON.parse(filter);                  
    
	       document.getElementById("agruCliente").checked = filter.agruCli;
           document.getElementById("agruProduto").checked = filter.agruPro;
           document.getElementById("agruMarca").checked = filter.agruMar;
           document.getElementById("agruModelo").checked = filter.agruMod;
           document.getElementById("agruMemoria").checked = filter.agruMem;
           document.getElementById("agruSO").checked = filter.agruSO;
           document.getElementById("agruVersaoSO").checked = filter.agruVSO;
	       $('#cliente').selectpicker('val', filter.cliente.split(', '));
	       $('#produto').selectpicker('val', filter.produto.split(', '));
	       $('#marca').selectpicker('val', filter.marca.split(', '));
	       $('#modelo').selectpicker('val', filter.modelo.split(', '));
	       $('#memoria').selectpicker('val', filter.memoria.split(', '));
	       $('#so').selectpicker('val', filter.so.split(', '));
	       $('#vso').selectpicker('val', filter.vso.split(', '));
	       if (filter.tipoCliente == "")
	           document.getElementById("todosClientes").checked = true;
	       else if (filter.tipoCliente == "1")
		       document.getElementById("apenasAtivos").checked = true;
	       else
		       document.getElementById("apenasInativos").checked = true;
	       Filtrar();
		}
	}
}

// Monta um string com os itens do elemento que foram selecionados
function Selecionados(elemento, comAspas)
{
	var selecao = elemento; 
    var selecionados = "";
    for (var i = 0; i < selecao.length; i++) 
	{
        if (selecao.options[i].selected) 
		{
		   if (comAspas)
		      selecionados = selecionados + "'" + selecao.options[i].value + "', ";
		  else
			selecionados = selecionados + selecao.options[i].value + ", ";  
		}
    }
	if (selecionados.length > 0)
	    selecionados =  selecionados.substring(0, selecionados.length - 2);
	
	return selecionados;
}

// Realiza a chamada para a seleção dos dados da tabela
function Filtrar() 
{
  if (!document.getElementById("agruCliente").checked && !document.getElementById("agruProduto").checked &&
      !document.getElementById("agruMarca").checked && !document.getElementById("agruModelo").checked &&
	  !document.getElementById("agruMemoria").checked && !document.getElementById("agruSO").checked && 
	  !document.getElementById("agruVersaoSO").checked)
  {
	  document.getElementById("txtGrid").innerHTML="";
	  document.getElementById("txtMsg").innerHTML = "ATENÇÃO!!! Selecione pelo menos um agrupamento!";  
	  return;
  }
  
  var tipoCli = "";
  if (document.getElementById("apenasAtivos").checked)
	 tipoCli = "1";
  else if (document.getElementById("apenasInativos").checked)
	 tipoCli = "0";
  var obj, dbParam;
  obj = {"agruCli": document.getElementById("agruCliente").checked, 
         "agruPro": document.getElementById("agruProduto").checked, 
         "agruMar": document.getElementById("agruMarca").checked, 
         "agruMod": document.getElementById("agruModelo").checked, 
         "agruMem": document.getElementById("agruMemoria").checked, 
         "agruSO": document.getElementById("agruSO").checked, 
         "agruVSO": document.getElementById("agruVersaoSO").checked, 
		 "cliente": Selecionados(document.getElementById("cliente"), true),
		 "produto": Selecionados(document.getElementById("produto"), true),
         "marca": Selecionados(document.getElementById("marca"), true), 
         "modelo": Selecionados(document.getElementById("modelo"), true),
		 "memoria": Selecionados(document.getElementById("memoria"), false),
		 "so": Selecionados(document.getElementById("so"), true),
		 "vso": Selecionados(document.getElementById("vso"), true),
         "tipoCliente" : tipoCli };
		 
  dbParam = JSON.stringify(obj);
  if (window.XMLHttpRequest) 
  {
    // IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } 
  else 
  { // IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() 
  {
    if (this.readyState==4 && this.status==200) 
    {
      document.getElementById("txtGrid").innerHTML=this.responseText;
	  document.getElementById("txtMsg").innerHTML = "";  
    }
  }
  xmlhttp.open("GET","getTable.php?x=" + dbParam,true);
  xmlhttp.send();

 setSessionFilters();
}

// Limpa os filtros, tabela e mensagem
function Limpar()
{
	document.getElementById("agruCliente").checked = false;
    document.getElementById("agruProduto").checked = false;
    document.getElementById("agruMarca").checked = false;
    document.getElementById("agruModelo").checked = false;
    document.getElementById("agruMemoria").checked = false;
    document.getElementById("agruSO").checked = false;
    document.getElementById("agruVersaoSO").checked = false;
	$('.selectpicker').selectpicker('val', '');
	document.getElementById("todosClientes").checked = true;
    document.getElementById("txtGrid").innerHTML = ""; 
    document.getElementById("txtMsg").innerHTML = ""; 

   sessionStorage.clear();	
}

// Realiza o download do arquivo CSV
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    csvFile = new Blob([csv], {type: "text/csv"});
    downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}

// Exporta os dados da tabela para o arquivo CSV
function Exportar()
{
   if (document.getElementById("aparelhos")== null)
   {
	  document.getElementById("txtMsg").innerHTML = "ATENÇÃO!!! Não existem dados para serem exportados";  
	  return;
   }
	var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) 
	{
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }
	
    downloadCSV(csv.join("\n"), "arqTab.csv");
}