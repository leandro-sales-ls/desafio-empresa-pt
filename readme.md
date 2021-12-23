

## Para levantar o container 
```
docker-compose up -d
```

## Para instalar as dependencias;
```
docker-compose exec php composer install
```

## Para realizar a criação da tabela
```
docker exec -i mysqlsrv mysql -u root --password=root! phprs < ./table.sql
```


## Efetuando testes na apliação

##### OBS: pode mudar os parametros para testar as demais validações


```
php bin/console create Leandro Sales leandro@sales.com 23
```

```
php bin/console create-pwd 1 Abc@132 Abc@132
```