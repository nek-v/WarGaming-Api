# Wargaming Api 
[![Build Status](https://travis-ci.org/nek-v/wargaming-api.svg?branch=master)](https://travis-ci.org/nek-v/wargaming-api)
[![Coverage](https://codecov.io/gh/nek-v/wargaming-api/branch/master/graph/badge.svg)](https://codecov.io/gh/nek-v/wargaming-api)
[![GitHub tag](https://img.shields.io/github/tag/nek-v/wargaming-api.svg)]()
[![GitHub license](https://img.shields.io/github/license/nek-v/wargaming-api.svg)](https://github.com/nek-v/wargaming-api/blob/master/LICENSE.md)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/nek-v/wargaming-api.svg)]()
[![GitHub issues](https://img.shields.io/github/issues/nek-v/wargaming-api.svg)](https://github.com/nek-v/wargaming-api/issues)

This package composer, allows to use more simply the 
**wargaming API** with a very simple and well documented 
object-oriented code for your IDE (*integrated development environment*).

1) Get your application id [here](https://developers.wargaming.net/applications/)
2) Initialise your application

| Region        | code |
| ------------- | ---- |
| Russia        | ru   |
| Europe        | eu   |
| Asia          | asia |
| North America | na   |

3) Make request
```php
$WarGaming = new WargamingApi($application_id = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx", $region = "eu");
```
1) Search player
```php
$WarGaming->searchPlayers($search = "volca", $options = [
    "limit"     => 10,
    "method"    => "startswith",
    "region"    => "eu"
]);
```
2) Search player(s) by id
```php
$WarGaming->infoPlayersById($players_id = ["500080014", "514444123", "514444121"], $options = [
    "region" => "eu"
]);
```
3) Server info
```php
$WarGaming->serverInfo($region = "eu");
```
4) Search clans
```php
$WarGaming->searchClans($search = "volca", $options = [
    "limit"         => 10,
    "pagination"    => "1",
    "region"        => "eu"
]);
```
5) Search clans by id
```php
$WarGaming->infoClansById($clans_id = ["500041879", "500034196"], $options = [
    "region" => "eu"
]);
```
5) Search clans of player(s) id
```php
$WarGaming->playerClans($players_id = ["500450795", "503197062", "500435236"]);
```

