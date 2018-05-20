<?php include "templates/header.php"; ?>

<body onload="SelecionarDadosGrafico()">

<script>
// Seta a aba corrente como sendo a do grafico1
$("#tabela").removeClass("current");
$("#grafico1").addClass("current");
$("#grafico2").removeClass("current");

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
  xmlhttp.open("GET","getChart.php",true);
  xmlhttp.send();
}

// Encontra os dados para os eixos do gráfico
function EncontrarAxis()
{
	var axis = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) 
	{
	   var cols = rows[i].querySelectorAll(".versao");
        
        for (var j = 0; j < cols.length; j++) 
	       axis.push('Android ' + cols[j].innerText);	   
    }
	return axis;
}

// Encontra os dados para as series do gráfico
function EncontrarSeries()
{
	var series = [];
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) 
	{
	   var cols = rows[i].querySelectorAll(".quantidade");
        
        for (var j = 0; j < cols.length; j++) 
	      series.push(cols[j].innerText);	   
    }
	return series;
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
					 title: {
                              text: 'Quantidade de cada versão de android utilizada pelos clientes ativos'
                            },
                    tooltip: {
                        show: true
                    },
                    xAxis : [
                        {
						    type : 'value'              
                        }
                    ],
                    yAxis : [
                        {
                            type : 'category',
						    data : EncontrarAxis()
                        }
                    ],
                    series : [
                        {
                            "name":"Versão/Quantidade",
                            "type":"bar",
						   "data": EncontrarSeries()
                        }
                    ]
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