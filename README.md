# Symfony Blog Project

Projekt bloga w Symfony.

## Wymagania

- PHP
- Composer  
- Node.js + npm / yarn (dla assetów)  
- Baza danych (MySQL / MariaDB lub PostgreSQL)  
- Git  

## Instalacja krok po kroku

1. **Sklonuj repozytorium**
   ```bash
   git clone https://github.com/nicolaszwaja/symfony-project.git
   cd symfony-project

1. **Zainstaluj zależności PHP**
    ```bash
    composer install

1. **Ustaw dane do połączenia z bazą danych, skonfiguruj plik .env**
   ```bash
    DATABASE_URL="mysql://user:password@127.0.0.1:3306/symfony_project"
1. **Utwórz bazę danych i wykonaj migracje**
   ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

1. **Załadowanie Fixtures**
   ```bash
   php bin/console doctrine:fixtures:load

1. **Uruchom serwer deweloperski**
   ```bash
    php -S 127.0.0.1:8000 -t public

## Funkcjonalności

- **Administrator**: logowanie, zarządzanie postami, kategoriami i komentarzami.  
- **Użytkownik**: przeglądanie treści, dodawanie komentarzy bez logowania.  
- **Posty**: CRUD, przypisywanie do kategorii, lista od najnowszych z paginacją (10 na stronę).  
- **Kategorie**: CRUD + powiązanie z postami.  
- **Komentarze**: dodawanie (nick, e-mail, treść), usuwanie przez administratora.
