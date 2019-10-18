Booking Code Challenge
==

Problem definition
---

We own an apartment and we’re renting it through different popular web sites. Before
actually renting the apartment for some days, those platforms send us booking requests. We
want to get insights from those booking requests in order to make better decisions. For
instance, we’d like to know what’s the profit per night we’re getting and what could be the
best combination of bookings to maximize our profits.

We will create an API for this purpose. 

**/stats endpoint**

Given a list of booking requests, return the average, minimum, and maximum profit per
night taking into account all the booking requests in the payload. 

Example request:

POST /stats
```
[
    {
        "request_id":"bookata_XY123",
        "check_in":"2020-01-01",
        "nights":5,
        "selling_rate":200,
        "margin":20
    },
    {
        "request_id":"kayete_PP234",
        "check_in":"2020-01-04",
        "nights":4,
        "selling_rate":156,
        "margin":22
    }
]
```
Example response:

```
200 OK

{
    "avg_night":8.29,
    "min_night":8,
    "max_night":8.58
}
```


## Installation step by step with Docker

1. Install [docker](https://docs.docker.com/compose/install/) and [docker-compose](https://docs.docker.com/compose/install/#install-compose)

2. Build/run containers with (with and without detached mode)

    ```bash
    $ docker-compose build && docker-compose up -d
    ```

3. Update your system host file (add booking.local)

    ```bash
    # UNIX only: get containers IP address and update host (replace IP according to your configuration) (on Windows, edit C:\Windows\System32\drivers\etc\hosts)
    $ sudo echo "127.0.0.1 booking.local" >> /etc/hosts
    ```

    **Note:** For **OS X**, please take a look [here](https://docs.docker.com/docker-for-mac/networking/) and for **Windows** read [this](https://docs.docker.com/docker-for-windows/#/step-4-explore-the-application-and-run-examples) (4th step).

4. Prepare Backend app

    1. Go to root directory
    2. Composer install

        ```bash
        $ docker-compose exec php composer install
        ```

5. Enjoy :-)

* Visit [booking.local:8081](http://booking.local:8081)  


## Usage

Just run `docker-compose up -d`, then:

* App: visit [booking.local:8081](http://booking.local:8081)  

**cURL**

```bash
POST

curl -X POST http://booking.local:8081/api/v1/booking/stats \
  -H 'Content-Type: application/json' \
  -d '[
    {
        "request_id":"bookata_XY123",
        "check_in":"2020-01-01",
        "nights":5,
        "selling_rate":200,
        "margin":20
    },
    {
        "request_id":"kayete_PP234",
        "check_in":"2020-01-04",
        "nights":4,
        "selling_rate":156,
        "margin":22
    }]'
  
RESPONSE STATUS 200:    
                                                             
{
    "avg_night": 8.29,
    "min_night": 8,
    "max_night": 8.58
}

RESPONSE STATUS 400:   
                                                              
{
    "message": "Error! Field nights is mandatory"
}
```

**Testing**

```bash
$ docker-compose exec php cp phpunit.xml.dist phpunit.xml 
$ docker-compose exec php ./vendor/bin/phpunit

PHPUnit 7.5.16 by Sebastian Bergmann and contributors.
........................................                          40 / 40 (100%)

Time: 133 ms, Memory: 8.00 MB
OK (40 tests, 60 assertions)
```

Coverage
```
$ docker-compose exec php ./vendor/bin/phpunit --coverage-text
```

## Usage

Just run `docker-compose up -d`, then:

* App: visit [booking.local:8081](http://booking.local:8081)  

## How it works?

Have a look at the `docker-compose.yml` file, here are the `docker-compose` built images:

* `nginx`: This is the server container
* `php`: This is the PHP-FPM and Apache2 container in which the application volume is mounted

This results in the following running containers:

```bash
$ docker-compose ps 

      Name                     Command               State                Ports              
---------------------------------------------------------------------------------------------
booking_nginx_1   nginx                            Up      443/tcp, 0.0.0.0:8081->80/tcp   
booking_php_1     docker-php-entrypoint php- ...   Up      9000/tcp, 0.0.0.0:9001->9001/tcp

```

## Useful commands

```bash
# access to container
$ docker-compose exec php sh

# Composer (e.g. composer install)
$ docker-compose exec php composer install

# Symfony commands
$ docker-compose exec php /var/www/bin/console cache:clear 

# Retrieve an IP Address (here for the nginx container)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress

# Delete all containers
$ docker rm $(docker ps -aq)

# Delete all images
$ docker rmi $(docker images -q)
```

## FAQ

* Got this error: `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?
If it's at a non-standard location, specify the URL with the DOCKER_HOST environment variable.` ?  
Run `docker-compose up -d` instead.

* Permission problem? See [this doc (Setting up Permission)](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup)