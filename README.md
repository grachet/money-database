# Erobot 

---
Currency database with personal pages and publications in Symfony 3.2 (end of year project)

---


1. Get the code

* git clone https://github.com/grachet/erobot.git

---

2. Define parameters (password...)

* Modify app/config/parameters.yml

---

3. Download vendors

* composer install

---

4. Create Database

* php bin/console doctrine:database:create

* php bin/console doctrine:schema:update --dump-sql

* php bin/console doctrine:schema:update --force

* php bin/console doctrine:fixtures:load

---

5. Publish assets in /web 

* php bin/console assets:install web
