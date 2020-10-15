# PHP Slim 4 Basic restful API

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/f6fe2d1c42334960bcc3bf7c3b0ccea8)](https://www.codacy.com/gh/ajsevillano/api.uniondistribuidora.com/dashboard?utm_source=github.com&utm_medium=referral&utm_content=ajsevillano/api.uniondistribuidora.com&utm_campaign=Badge_Grade)

This is a basic RESTful API designed for a customer.The API will allow you to fech information from a products and customers table in the databes and allow you to read,create and update them. Delete request is not allow at this time.

## Motivation

Despite of my frontend background, I wanted to create a basic Restapi in PHP using [PHP Slim 4 framework](http://www.slimframework.com/) to serve as backend on some of my projects.

## Installation

You can download the project in [zip](https://github.com/ajsevillano/api.uniondistribuidora.com/archive/main.zip) format or clone with:

```php
gh repo clone ajsevillano/api.uniondistribuidora.com
```

- Download and install composer from [here](https://getcomposer.org/download/)
- Then install all the project's dependencies:

```bash
php composer.phar update
```

I will create a file with the database structure and some dummy data for testing in next releases.

## GET ENDPOINDS

The API will provived you some endpoints:

```html
GET /products <- It will return a full json list of the products in the DB.
```

```html
GET /products/id <- It will return an unique product based on its ID. Only
numerics IDs are allow.
```

```html
GET /customers <- It will return a full json list of the customers in the DB.
```

```html
GET /customers/id <- It will return an unique customer based on its ID. Only
numerics IDs are allow.
```

## POST PRODUCTS ENDPOINDS

```html
POST /products
```

You will need to send a json object to create a new item in the next format:

```json
{
  "tipo": "type of drink",
  "marca": "Brand",
  "tamano": "Size",
  "nombre": "Name",
  "activo": "0"
}
```

## PUT PRODUCTS ENDPOINDS

```html
Put /products
```

You will need to send a json object to update an item based in its ID in the next format:

```json
{
  "id": "an numeric id",
  "tipo": "beer",
  "marca": "Brand",
  "tamano": "Size",
  "nombre": "Name",
  "activo": "0"
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
