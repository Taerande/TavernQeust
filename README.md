<p align="center">
<a href="http://tavernquest-v2.web.app/" target="_blank">
  <img src="./logo128.png" width="60" title="TavernQuest Logo Image">
  <img src="./tq-title.png" width="250" title="TavernQuest Logo Title">
</a>
</p>

## About Tavern Quest

Tavern Quest 는

## Back-End Structure

<p>
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=Laravel&logoColor=white" height="20">
    <img src="https://img.shields.io/badge/Google Cloud Platform-4285F4?style=flat&logo=GoogleCloud&logoColor=white" height="20">
    <img src="https://img.shields.io/badge/Maria DB-003545?style=flat&logo=MariaDB&logoColor=white" height="20">
    <img src="https://img.shields.io/badge/Nginx-009639?style=flat&logo=NGINX&logoColor=white" height="20">
</p>

1. 현재 구성

-   GCP - Compute Engine에 개발환경 구축
-   Webserver : Nginx
-   Database : MaraiaDB
-   Back-End API : Laravel
-   Front-End : React

2. 추후 변경할 내용

-   Database

    -   GCP - SQL, GCP - Storage 연동

-   Backend API
    -   경로 변경 및 Web Routing 추가
    -   Controller의 Validation을 Policy로 나누기
    -   Laravel Sanctum Ability 추가 및 설정
    -   Review, Message System 만들기

## API

### 추후 Swagger나 다른 API문서 형태로 제공할 예정

1. Schedule
2. Party
3. User
4. Character
5. Member
6. Blizzard Tokens

## Test User

```
ID: user@user.com
PASSWORD : password

ID: test@test.com
PASSWORD : password
```

## Install

1. Install dependency

```
composer update
```

2. Set Database

```
mysql -u root -p
CREATE DATABASE tavernquest
php artisan migrate:refresh --seed
```

3. Run server with apache2

```
php artisan serve
```
