<?php include "templates/header.php"; ?>

<body onload="SelecionarDadosGrafico()">

<script>
// Seta a aba corrente como sendo a do grafico2
$("#tabela").removeClass("current");
$("#grafico1").removeClass("current");
$("#grafico2").addClass("current");

// Realiza a chamada para a seleção dos dados do gráfico
function SelecionarDadosGrafico() 
{
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
      document.getElementById("txtTabela").innerHTML=this.responseText;
	  document.getElementById("txtTabela").style.display = 'none'; 
	  MontaGrafico();
    }
  }
  xmlhttp.open("GET","getChart2.php",true);
  xmlhttp.send();
}

// Encontra os dados para os eixos do gráfico
function EncontrarAxis()
{
	var axis = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) 
	{
	   var cols = rows[i].querySelectorAll(".data");
        
        for (var j = 0; j < cols.length; j++) 
		  if (axis.indexOf(cols[j].innerText) < 0)
		  {	 
			axis.push(cols[j].innerText);
		  }  
    }
	return axis;
}

// Encontra os dados para as series do gráfico
function EncontrarSeries()
{
	var csv = "";
	var series = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) 
	{
	   var cols = rows[i].querySelectorAll(".versao");
               
	   for (var j = 0; j < cols.length; j++) 
		{
			if (!VerificarObjectPropInArray(series, "name", "versão " + cols[j].innerText))
			{
			  var serie = {name:"versão " + cols[j].innerText, type:"bar", data:EncontrarQuantidadesSerie(cols[j].innerText).split(",")};
		       series.push(serie);
		    }
        }        
    }
	return series;
}

// Verifica se o objeto com a propriedade e valor passados, já se encontra no array
function VerificarObjectPropInArray(list, prop, val) 
{
  if (list.length > 0 ) 
  {
    for (i in list)
	{
      if (list[i][prop] === val)
        return true;
    }
  }
  return false;  
}

// Encontra valor da quantidade para a serie passada como parâmetro
function EncontrarQuantidadesSerie(serie)
{
	var qtds = "";
	var versao = serie.replace(/[.]/g, "_");
	var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) 
	{
	 var cols = rows[i].querySelectorAll(".quantidade_" + versao);
     for (var j = 0; j < cols.length; j++) 
        qtds = qtds + cols[j].innerText + ", ";    	   
    }
	return qtds.substring(0, qtds.length - 2);
}

// Monta o gráfico a partir dos eixos e series 
function MontaGrafico()
{
	require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        require(
            [
                'echarts',
                'echarts/chart/bar' 
            ],
            function (ec) {

                var myChart = ec.init(document.getElementById('main')); 
		
                var option = {
					color : [ 
                         '#ff7f50', '#87cefa', '#da70d6', '#32cd32', '#6495ed', 
                         '#ff69b4', '#ba55d3', '#cd5c5c', '#ffa500', '#40e0d0', 
                         '#1e90ff', '#ff6347', '#7b68ee', '#00fa9a', '#ffd700', 
                         '#6b8e23', '#ff00ff', '#3cb371', '#b8860b', '#30e0e0' 
                     ],
					 title: {
                              text: 'Histórico da quantidade de clientes utilizando cada versão do android por data'
                            },
					 tooltip: {
                        trigger: 'axis',
                        backgroundColor: 'rgba(255,255,255,0.7)',
                        axisPointer: {
                                      type: 'shadow'
                                     },
                        formatter: function(params) {
						var colorSpan = color => '<span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:' + color + '"></span>';
                        var res = '<div style="color:' + 'rgba(0,0,0,0.9)' + '">';
                        res += '<strong>' + params[0].name + '</strong>'
                        for (var i = 0, l = params.length; i < l; i++) {
							console.log(params[i]);
						res += '<br/>' + colorSpan(option.color[i%20]) + ' ' + params[i].seriesName + ' : ' + params[i].value 
                        }
                        res += '</div>';
                        return res;
                       } 
                    },	
                    xAxis : [
					    {
                            type : 'category',
						    data : EncontrarAxis()
                        }    
                    ],
                    yAxis : [
                         {
						    type : 'value'              
                        }
                    ],
				series :      
					   EncontrarSeries()					 
                };
       
                myChart.setOption(option); 
            }
        );
}

</script>

<script src="http://echarts.baidu.com/build/dist/echarts.js"></script>

<div id="txtTabela" ><b>Tabela será exibida aqui...</b></div> 
<div id="main" style="height:400px; margin: 15px;"></div>

<?php include "templates/footer.php"; ?>