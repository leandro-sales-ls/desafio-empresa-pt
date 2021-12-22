

## Para levantar o container 
docker-compose up -d

## Para instalar as dependencias;
docker-compose exec php composer install


## Efetuando testes na apliação

##### OBS: Ids que irão passar na vaildação do segundo teste são [1,3,5,9,35,10];

##### OBS: pode mudar os parametros para testar as demais validações


### Dentro do docker 

```
docker-compose exec php php bin/console create Leandro Sales leandro@sales.com 23
```

```
docker-compose exec php php bin/console create-pwd 1 Abc@132 Abc@132
```

### Fora do docker

```
php bin/console create Leandro Sales leandro@sales.com 23
```

```
php bin/console create-pwd 1 Abc@132 Abc@132
```