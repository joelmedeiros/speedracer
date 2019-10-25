## Getting started

You will need [Docker](https://www.docker.com/get-started) and [Docker-Compose](https://docs.docker.com/compose/) installed to build this application.

Run the commands below on your favorite terminal inside the project folder:
 
```bash
docker-compose up -d
docker-compose exec php composer install
```

### Running tests
All tests were write using [codeception](https://codeception.com) library, then we need to use its commands to run all tests:

```bash
docker-compose exec php vendor/bin/codecept run
``` 

### Running command

A command is available to read a log file and output the race result:

```bash
 docker-compose exec php bin/console speedracer:show-results $(YOUR_FILE)
```
There is an example file created to support your experience.

```bash
 docker-compose exec php bin/console speedracer:show-results tests/_data/race.log
```
