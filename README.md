# SiteFotografia
### Site para divulgação do trabalho de um fotografo junto com um CMS integrado.

Esse site foi iniciado o desenvolvimento em junho de 2020. Escolhi o laravel para desenvolver por conta da sua praticidade e para colocar em prática meus conhecimentos em cima do framework. Utilizando os recursos ja dísponiveis e usando também da criatividade para pode criar o layout do jeito que o cliente gostaria. O front-end foi desenvolvido usando o html, css, javascript e bootstrap e o blade do próprio laravel.

A versão desse repositório não consta os antigos commits que eu utilizei durante o desenvolvimento, por conta do projeto original ter sido perdido. Então a versão aqui listada ja é o site pronto e sendo utilizado nesse momento.

# Instalação 

Primeiramente use o composer update ou composer install para criar a pasta vendor. Também execute o comando npm install por conta dos pacotes em Node. Após isso importe o arquivo sql bdfotografia.sql no seu banco de dados (Não fiz o uso de migrations por não conhecer ainda). Ao fazer isso, vá no arquivo .env.exemple e mude as configurações para as escolhidas por você. As principais são as citadas abaixo:

# ENV Configurações
### API_URL="url local ou da hospedagem" 
### APP_ENV=local ou developmente 
### DB_DATABASE=nome banco de dados 
### DB_USERNAME=usuario do banco de dados 
### DB_PASSWORD=senha do banco de dados

#### Após preencher o arquivo env.example renomeie o arquivo para .env

Após essas configurações utilize o php artisan key:generate para criar um nova chave, agora basta usar o php artisan serve para iniciar a aplicação caso esteja local.
