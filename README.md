# oc_project7_bilemo

### Openclassrooms / Projet 7 : Créez un web service exposant une API
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d35805b70ab545b29a19463240a8c00f)](https://www.codacy.com/manual/esauvage1978/oc_project7_bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=esauvage1978/oc_project7_bilemo&amp;utm_campaign=Badge_Grade)


## Getting Started

1. copy repository `git clone https://github.com/esauvage1978/oc_project7_bilemo.git`
2. update "require": "4.3.*" of section Symfony in composer.json
3. `composer install`
4. update "require": "4.4.*" of section Symfony in composer.json
5. `composer update`
6. Copy et rename `.env.local` to `.env` and  configure BDD connect on `.env` file and dev environnement (APP_ENV=dev)
7. Create database `php bin/console doctrine:database:create`
8. Create sql file  `php bin/console make:migration`
9. Migrate table on database  `php bin/console doctrine:migrations:migrate`
10. (for test) load fixtures into the database `php bin/console doctrine:fixtures:load`
11. configure the producion environnement in `.env` file (APP_ENV=prod)

You can see the documentation to the url : GET api/doc
##
**Generate the SSH keys for JWT With OPENSSL**

``` bash
$ mkdir -p config/jwt 
$ openssl genrsa -out config/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
Be careful: you must put the path phrase in the .env file

I make this with Win64OpenSSL-1_1_0L.exe in windows 10

##
**Getting a token**

```bash
curl -X POST -H "Content-Type: application/json" {yourdomain}/api/login_check -d '{"username":"{yourusername}", "password":"{yourpassword}"}'

```

in ClientFixture, you can add an account or use the present account .

{yourusername} : emmanuel.sauvage@live.fr
{yourpassword} : mdp

You should have an answer like this:

```json
{
   "token" : "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9.eyJleHAiOjE0MzQ3Mjc1MzYsInVzZXJuYW1lIjoia29ybGVvbiIsImlhdCI6IjE0MzQ2NDExMzYifQ.nh0L_wuJy6ZKIQWh6OrW5hdLkviTs1_bau2GqYdDCB0Yqy_RplkFghsuqMpsFls8zKEErdX5TYCOR7muX0aQvQxGQ4mpBkvMDhJ4-pE4ct2obeMTr_s4X8nC00rBYPofrOONUOR4utbzvbd4d2xT_tj4TdR_0tsr91Y7VskCRFnoXAnNT-qQb7ci7HIBTbutb9zVStOFejrb4aLbr7Fl4byeIEYgp2Gd7gY"
}
```

**Authentification**

```bash
curl -H "Authorization: Bearer {yourtoken}" {yourdomain}/api
```
Now, you can see this operations:

GET /api/products

GET /api/products/{id}

GET /api/users/{id}

GET /api/users

DELETE /api/users/{id}

PUT /api/users/{id}
