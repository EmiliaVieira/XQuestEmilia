Esta aplicação se conecta ao MySQL usando PHP.
Foi utilizado o MAMP para instalar PHP e MySQL,
para gerenciar a base de dados foi utilizado o SQLYog.

A aplicação mostra informações sobre os equipamentos
utilizados pelos clientes.

O primeiro passo é executar a criação da base de dados,
para isso no browser digite:
localhost/install.php
como mostra a figura createDatabase.png, a base de
dados será criada e populada.

Depois no browser digite:
localhost

Na primeira aba, como mostra a figura table.png, 
são disponibilizadas opções de filtro e ao acionar
o botão 'Filtrar' é exibida uma tabela com os resultados.
Nesta aba há também o botão 'Exportar' que permite 
que os dados da tabela sejam exportados para um arquivo
CSV, que terá o nome arqTab.csv e será salvo na pasta Download.

Na segunda aba, Grafico1, é exibido o gráfico da quantidade
de cada versão android utilizada pelos clientes ativos,
conforme mostra a figura chart1.png.

Na terceira aba, Grafico2, é exibido o gráfico do histórico
da quantidade de clientes utilizando cada versão do android
por data, como mostra a figura chart2.png.

