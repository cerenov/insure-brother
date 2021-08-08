### Комментарии по выполнению

После того как проект будет развернут, нужно выполнить комманды: 
```sh
docker exec -it insure_brother-app npm install
docker exec -it insure_brother-app npm run dev
docker exec -it insure_brother-app php artisan migrate
```

В файле .env нужно настроить параметры
```sh
MAIL_MAILER
MAIL_HOST
MAIL_PORT
MAIL_USERNAME
MAIL_PASSWORD
MAIL_ENCRYPTION
MAIL_FROM_ADDRESS
MAIL_FROM_NAME
```
почту тестировал через smtp.mailtrap.io