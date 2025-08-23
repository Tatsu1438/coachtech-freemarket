# coachtech-freemarket

#　環境構築
Dockerビルド

    git clone git@github.com:Tatsu1438/coachtech-freemarket.git
    docker-compose up -d --build

Laravel環境構築

    docker-compose exec php bash
    composer install
    環境変数を変更
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
