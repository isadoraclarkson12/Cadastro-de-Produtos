Para o funcionamento do sistema:<br><br><br><br>
1º passo: será necessário efetuar o download do XAMPP SERVER no link https://www.apachefriends.org/pt_br/download.html e escolher a atual versão (7.2.29).<br><br>
2º passo: depois de instalado, pesquisar no menu iniciar por XAMPP Control Panel.<br><br>
3º passo: clicar em start nos módulos Apache e Mysql. Depois de iniciar o módulo Mysql, ir até o botão admin, e dentro do PhpMyAdmin criar um novo banco de dados com o nome "vendas".<br><br>
4º passo: depois de criado o banco, importar o arquivo "vendas.sql".<br><br>
5º passo: criar uma pasta com o nome desejado dentro do caminho "C:\Xampp\htdocs\nome_pasta".<br><br>
6º passo: colar as pastas api e adm dentro da pasta mencionada acima.<br><br>
7º passo: abrir o navegador e acessar "localhost/nome_pasta/adm/login" e utilizar o nome de usuário "master" e senha "master".<br><br><br>

<strong>Obs: as instruções anteriores são baseadas em um usuário 'root' padrão sem senha. Caso a máquina já tenha um usuário e senha configurado para o banco de dados MySql, alterar os dados de conexão dentro da pasta "api/application/config/database.php".</strong>

