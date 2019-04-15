# Uplexis-Laravel

## Configurando o sistema para testes:
- Instalar php 7 e mysql: O sistema foi desenvolvido utilizando o framework Laravel 5.8 da linguagem PHP. Assim para a realização dos testes é necessário a instalação do PHP 7 e o gerênciador de bando de dados Mysql. Para mais informações sobre o framework acessar https://laravel.com/docs/5.8 .

- Criar banco de dados. Com gerênciador instalado criar o banco de dados com as seguintes configurações:
-		nome = blogUplexis, usuario = root, senha = root, host = 127.0.0.1
	
- Com as configurações feitas baixe o repositório do Git em seu computador.
- Agora vá até a pasta do repositório ("/Uplexis-Laravel/app-uplexis/") e faça uma cópia do arquivo ".env.example" e salve na própria pasta com o nome ".env" 
- Via terminal de comando acesse a pasta do repositorio ("/Uplexis-Laravel/app-uplexis/"). Nela iremos rodar alguns comandos para o start do framework Laravel:
- Primeiro rode o comando
-		composer update
- Ele irá baixar e instalar as dependêndias necessárias para o sistema funcionar corretamente. Em seguida o comando:
-		php artisan migrate
- Este comando irá criar as tabelas utilizadas pelo sistema no bando de dados. No Laravel o controle do banco de dados é realizado via código. Isso facilita a manutenção e até mesmo um versionamento do mesmo.
Em seguida rode o seguinte comando:
-       php artisan key:generate
- Este comando gera uma chave necessária para que o framework Laravel funcione.
## Testar a Aplicação

- Para testar a aplicação o Laravel precisa estar com um servidor PHP startado, assim o próprio Laravel possui um simulador de servidor. Para iniciá-lo vá até a pasta do repositorio ("/Uplexis-Laravel/app-uplexis/"), via terminal, e digite o comando:
-		php artisan serve
Logo após a aplicação Laravel poderá ser acessada através da URL http://127.0.0.1:8000/

- O Laravel já possui um sistema de testes unitários e de features integrados em seu ambiente. Para rodar os testes basta ir via terminal na pasta do repositório ("/Uplexis-Laravel/app-uplexis/") e rodar o comando (para isso o servidor web precisa estar ativo):
-		vendor/bin/phpunit

## Utilizando a Aplicação

- Com o servidor startado acesse a url http://127.0.0.1:8000/. Após crie um resgistro de usuário. 
Com ele você terá acesso as funcionalidades de buscar novos, consultar e excluir posts.