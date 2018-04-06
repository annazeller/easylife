# easylife

## EasyLife im Docker Container installieren
Composer und [Docker](https://docs.docker.com/) müssen installiert sein

Repository clonen

    git clone https://github.com/annazeller/easylife.git

Change directory

    cd easylife

Dependencies installieren

    composer install

Docker Container bauen und hochfahren

    docker-compose up -d

Migration durchführen

  	docker-compose exec app php artisan migrate
  
Aufrufen unter

    http://localhost:8080

Zum Beenden der Container `docker-compose kill`, und zum Entfernen `docker-compose rm`
