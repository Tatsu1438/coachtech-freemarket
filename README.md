# coachtech-freemarket

#　環境構築

Dockerビルド

    1. git clone git@github.com:Tatsu1438/coachtech-freemarket.git
    2. cd coachtech-freemarket
    3. DockerDesktopアプリを立ち上げる
    4. docker-compose up -d --build

Laravel環境構築

    docker-compose exec php bash
    composer install
    環境変数を変更
    php artisan key:generate
    php artisan migrate
    php artisan db:seed

mysql:

    platform: linux/x86_64
    image: mysql:8.0.26
    environment:

laravel環境構築：

    1.docker-compose exec php bash
    2.composer install
    3.envに以下の環境変数を追加

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass

  アプリケーションキーの作成
  
    php artisan key:generate 

マイグレーションの実行
    
    php artisan migrate

users テーブルに current_weight と goal_weight を追加するマイグレーションを作る。

　　php artisan make:migration add_weight_columns_to_users_table --table=users
　　

シーディングの実行

    php artisan db:seed

シンボリックリンクの作成

    php artisan storage:link

使用技術

PHP 8.1-fpm

Laravel Framework 10.48.29

MySQL 8.0.26


ログインIDとパスワード

	•	メールアドレス: heaney.ivory@example.net

	•	パスワード: password

URL

開発環境：http://localhost/

phpMyAdmin: http://localhost:8083/
