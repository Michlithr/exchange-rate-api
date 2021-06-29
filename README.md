# exchange-rate-api
An exchange rate app. It allows you to check the current exchange rates and historical ones based on previous queries.

## Project Description
App is able to handle rates from currencies choosen by user (by using currency code e.g. EUR) to PLN. It also allowes user to choose a data of the currency rate he's looking for. App uses free, public NBP API (http://api.nbp.pl/). All queries via app are saved and used to build history of choosen exchange rate.

## Prepare app
### For running app you need: 
- mysql 
- php 8.0
- composer

### .env file 
In .env file you need to determine credentials for your db instance. E.g. for mysql db you should switch tips for you real data 
- ```DATABASE_URL="mysql://user:password@127.0.0.1:3306/db-name"```
- user - your db user like admin123
- password - your db password like Str00ngPass
- 127.0.0.1:3306 - db addres (do not change it if you are running db locally)
- db-name - name of your database like ex-rate-db
- example - ```DATABASE_URL="mysql://admin123:Str00ngPass@127.0.0.1:3306/ex-rate-db"```

### Installing libraries
By running ```composer install``` in terminal (in project directory) you should be able to installing all needed frameworks and libraries. 

### Running the app
The simply way to run this project is to e.g. using apache symfony pack to run it locally. You need to run ```composer require symfony/apache-pack``` in project directory. Other possible ways are described here - https://symfony.com/doc/current/setup/web_server_configuration.html. After configuring the way of deploying this project you run this App by writing ```symfony server:start``` in terminal (in project directory). It will start server on localhost:8000

## How to use
App contains two endpoints: 
- ```/api/exchangeRate?currencyCode=&date=``` which returns exchange rate (from choosen currency to PLN) for specified date, both query params are optional. Example: ```localhost:8000/api/exchangeRate?currencyCode=EUR&date=2021-06-29```
- ```/api/exchangeRate/historical?currencyCode=``` which returns exchange rates from first app use to current day for choosen cureency (from specified currency to PLN). Example: ```localhost:8000/api/exchangeRate/historical?currencyCode=EUR```

All the results are returned in json format. 

## Possible improvements 
- validating currency codes basing on codes available in choosen exchange rate API
- enabling the user to choose not only the currency for which we are looking for the exchange rate against PLN, but also the other one (currencies from and to)
- filtering historical data by specified 
- simple web app using this API to display current exchange rate and draw exchange rate chart based on historical data
- unit tests 
