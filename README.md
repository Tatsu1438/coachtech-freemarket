# coachtech-freemarket

## サービス名

coachtechフリマ

## サービス概要

ある企業が開発した独自のフリマアプリ

## 環境構築

## Dockerビルド

    1. git clone git@github.com:Tatsu1438/coachtech-freemarket.git
    2. cd coachtech-freemarket
    3. DockerDesktopアプリを立ち上げる
    4. docker-compose up -d --build

## Laravel環境構築

    docker-compose exec php bash
    composer install
    環境変数を以下に変更
	DB_CONNECTION=mysql
	DB_HOST=mysql
	DB_PORT=3306
	DB_DATABASE=laravel_db
	DB_USERNAME=laravel_user
	DB_PASSWORD=laravel_pass

	php artisan config:clear
 	php artisn cache:clear

## アプリケーションキーの作成
  
    php artisan key:generate
	php artisqan config:cache

## Productモデルとマイグレーション(test用と本番用)の作成&実行
 
    php artisan make:model Product -m

 	php artisan migrate --env=testing
  	php artisan make:migration
   	php artisan test --env=testing

## シーディングの作成&実行

 	php artisan make:seeder ProductSeeder
    php artisan db:seed

## シンボリックリンクの作成

    php artisan storage:link

## 使用技術（実行環境）

PHP:7.4.9

mysql:8.0

nginx:1.21.1

Laravel:8.x

## 開発環境

URL:

・画面: http://localhost/

・ユーザー登録: http://localhost/

・phpMyAdmin: http://localhost:8080/
   

## ER図







users テーブルに current_weight と goal_weight を追加するマイグレーションを作る。

　　php artisan make:migration add_weight_columns_to_users_table --table=users
　　



   








