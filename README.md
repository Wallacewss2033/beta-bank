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
  
![image](https://github.com/Wallacewss2033/beta-bank/assets/39920409/fe3d8002-6ff5-479a-a8dc-7ea39aeed6cf)



- Para criar o banco de dados
```
php artisan migrate
```

- Para popular o banco na tabela de usuário
```
php artisan db:seed
```

- Não esqueça de configurar o servidor extenal

![image](https://github.com/Wallacewss2033/beta-backend/assets/39920409/71114ff8-fc63-48e8-a5ab-c7077bf14adb)

- para rodar o comando de transações agendadas você pode testar a execução das tranfencias agendadas manualmente com o seguinte comando:
```
php artisan send:transactions
```

