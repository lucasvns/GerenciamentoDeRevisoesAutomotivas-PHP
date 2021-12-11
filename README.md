# GerenciamentoDeRevisoesAutomotivas-PHP

Atividade prática - Programação Orientada à Objeto


# Escopo do Projeto

Contextualização:
A indústria automotiva está presente no Brasil desde o início do século XX, e passa a
atuar de forma direta em território nacional a partir da década de 50 do mesmo século.
O primeiro automóvel no Brasil foi um Peugeot, modelo francês importado de navio até
a cidade de Santos, pelo jovem de 18 anos chamado Alberto Santos Dumont, em 1894.
A primeira empresa a estabelecer um escritório no país foi a Ford, em 1919. Em 1925
seria a vez da General Motors, ambas baseadas na capital paulista. Na década de 20
surge a primeira rodovia asfaltada, a Rio-Petrópolis, inaugurada pelo presidente
Washington Luís.

O verdadeiro nascimento da indústria automotiva ocorre durante os governos de Getúlio
Vargas e Juscelino Kubitschek. Kubitschek deu condições às indústrias no Brasil para
desenvolver localmente qualquer tecnologia estrangeira. A primazia do primeiro carro
100% fabricado nacionalmente coube à Romi, indústria de tornos e equipamentos
agrícolas, que obteve o licenciamento de um minicarro italiano, o Isetta. Surge assim,
em 1956, a Romi-Isetta, como ficou conhecida, com um motor semelhante ao de uma
motocicleta, rodas diminutas, aro 14 e somente uma porta, frontal. No mesmo ano,
outras fábricas, como a FNM (Fábrica Nacional de Motores) e a Vemag (de origem
alemã) lançavam carros totalmente nacionais, apesar de serem cópias licenciadas de
modelos baratos europeus e norte-americanos. Kubitschek criou ainda o GEIA - Grupo
Executivo da Indústria Automobilística, destinado a viabilizar as iniciativas de produção
de automóveis nacionais.

Em 1959 é a vez da Volkswagen, que instala sua filial em São Bernardo do Campo, SP,
e monta os primeiros Fuscas e Kombis nacionais. A empresa irá liderar o mercado de
automóveis no Brasil até o início dos anos 90. O automóvel nacional tornava-se uma
realidade palpável, e o cenário urbano já era "invadido" pelos modelos nacionais, que
ocupavam o espaço dos importados.

No fim dos anos 60 e início dos 70, o consumidor se torna mais exigente, e os modelos
passam a ter uma qualidade melhor, sendo que várias empresas pequenas surgem, com
destaque para a Gurgel e a Puma. Ao mesmo tempo, quatro empresas irão se consolidar
como as principais fabricantes do país, dominando quase todo o mercado: Volkswagen, 
GM, Ford e Fiat. Nos anos 90, a importação de veículos volta a ser estimulada, abrindo o
mercado brasileiro. Atualmente, o Brasil possui 20 empresas competindo em um
lucrativo mercado, onde estima-se que haja proporcionalmente um carro para cada
cidadão brasileiro na região da grande São Paulo.

Atividade:

Após participar de uma feira automotiva, um grupo chinês contratou sua empresa para
o desenvolvimento do seu sistema de gerenciamento de revisões automotivas. O grupo
possui unidades em várias cidades do país e oferece serviços de manutenção e revisão
para os clientes que compram seus automóveis. Contudo o grupo chinês enfreta
algumas dificuldades para gerenciar o cadastro de seus clientes – e isto está
prejudicando os lucros da empresa dado a alta competitividade do mercado automotivo.

O sistema a ser desenvolvido precisa ter as seguintes funcionalidades:
• Cadastro completo de clientes com:

◦ Nome

◦ Telefone

◦ Endereço

◦ CPF

• Cadastro de veículos pertencentes a clientes com:

◦ Número da placa

◦ Modelo/versão

◦ Ano de fabricação

◦ Valor de compra

• Agendamentos de revisões.

• Troca de datas de agendamentos de revisões.

• Cancelamentos de agendamentos de revisões.

• Relatório de quais serviços foram feitos para um determinado cliente e seu veículo.

• Capacidade de persistência de dados. A base de informações do sistema deverá ser salva em um banco de dados relacional.

Pontos a destacar:
O software será executado num servidor web.
No fim deverão ser entregues ao cliente o software funcionando para testes bem como
todos os códigos e diagramas desenvolvidos.

# Telas

Listagem de Clientes

![image](https://user-images.githubusercontent.com/60347505/145659706-ca8c8b1b-6370-4cb7-9152-9c7113593cc6.png)

- Filtro por Nome ;

Cadastro de Clientes

![image](https://user-images.githubusercontent.com/60347505/145658851-049a8c27-ef0e-4ebd-b788-4d58409c2f59.png)

- Mascara para Telefone ;
- Verificação de CPF válido e se já cadastrado no sistema ;

Listagem de Veiculos

![image](https://user-images.githubusercontent.com/60347505/145658990-a8adf290-4089-4046-9e54-277c18ea0a6b.png)

- Função de Adcionar e Remover ;

Cadastro de Veiculos

![image](https://user-images.githubusercontent.com/60347505/145658997-3ae05b6e-8b3a-4b59-a09a-1f6bea1c5e40.png)

- Mascara para Valor ;

Listagem de Revisões 

![image](https://user-images.githubusercontent.com/60347505/145659699-a6108147-181e-4d74-a146-8af5cd2557dc.png)

- Filtro de Cliente ;

Cadastro da Revisões

![image](https://user-images.githubusercontent.com/60347505/145658876-4fe0700d-adb7-4401-b55f-c1a910d083f5.png)

- Função para localizar veiculo ao selecionar cliente ;
- Mascara para data ;
- Mascara par Horário ;

Cadastro de Usuarios (Administradores)

![image](https://user-images.githubusercontent.com/60347505/145660011-18abf478-081e-4ad5-be45-0bf926e2b8b8.png)

- Cadastro de Permissões
- Alteração de Senha

# Como Utilizar 

Inicialemente adicione os arquivos a seu servidor apache e em seguida faça upload da base de dados disponibilizada dentro da pasta " Banco de Dados ";

Localize dentro da base de dados a tabela denominada "tparameter" e altere os endereços para o endereço do seu servidor;

Localiza dentros dos arquidos o arquivo denominado "configuração" que se encontra em /admin/alfa/database/ , dentro deste arquivo coloque os dados de conexão de seu banco de dados;

Caso seus arquivos estejam dentro de uma pasta certifique-se de que o caminho cadastrado no tabela "tparameter" esteja correto, e tambem verifique dentro da pasta admin o arquivo "barrier.php" e certifique que o caminho para o projeto está correto;



