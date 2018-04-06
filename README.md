# easylife

## EasyLife im Docker Container installieren
Composer und [Docker](https://docs.docker.com/) müssen installiert sein

Repository clonen

    git clone https://github.com/annazeller/easylife.git

Change directory

    cd easylife

Docker Container bauen und hochfahren

    docker-compose up -d

Dependencies installieren

 	docker-compose exec php composer install

Migration durchführen

  	docker-compose exec php php artisan migrate
  
Aufrufen unter

    http://localhost:8080

Zum Beenden der Container `docker-compose kill`, und zum Entfernen `docker-compose rm`
