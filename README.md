### Комментарии по выполнению

После того как проект будет развернут, нужно выполнить комманды: 
```sh
docker exec -it insure_brother-app npm install
docker exec -it insure_brother-app npm run dev
docker exec -it insure_brother-app php artisan migrate
```