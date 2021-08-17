O projeto utiliza um *mini* router implementado então somente jogar o projeto no apache não irá funcionar. Para rodar com o servidor embutido do PHP: 

O composer está para fazer o carregamento das classes conforme a PSR-4, primeiro rodar no diretório do projeto (não há bibliotecas externas):

``composer install``

Para rodar o projeto:

``php -S localhost:3000 -t ticket-sale-final``

Caso for utilizar o apache deve ser criado um arquivo .htaccess direcionando as requisições para o **index.php**

O diagrama do banco, escopo, requisitos e levantamento de requisitos estão no diretório *bin*

O script do banco é **schema.sql**