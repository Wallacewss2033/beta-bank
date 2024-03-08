## Instalação 


- Clone o projeto
```
git clone git@github.com:Wallacewss2033/beta-bank.git
```

### Back-end

- Entre na pasta do projeto ```beta-bank``` e instale as dependencias
```
composer install
```
- logo após rode esses comandos
```
cp .env.example .env
```
```
php artisan key:generate
```

- Não esqueça de configurar o banco de dados na ``` .env ```
  
![image](https://github.com/Wallacewss2033/fullstack-challenge-20231205/assets/39920409/ec726dce-7762-4c68-b66c-668698afad41)


- Para criar o banco de dados
```
php artisan migrate
```

- Para popular o banco na tabela de usuário
```
php artisan db:seed
```
