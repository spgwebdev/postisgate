## PostisGate API Client

A simple PostisGate implementation for Laravel.

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require seniorprogramming/postisgate

Now all you have to do is add the service provider of the package and alias the package. To do this open your `config/app.php` file.

Add a new line to the `providers` array:

	SeniorProgramming\PostisGate\Providers\ApiServiceProvider::class,

And optionally add a new line to the `aliases` array:

	'PostisGate' => SeniorProgramming\PostisGate\Facades\PostisGate::class,

Important, add in .env PostisGate credentials:

```env
POSTISGATE_USERNAME=
POSTISGATE_PASSWORD=
POSTISGATE_API=
```
And in `config/filesystems.php`

```php
    'postisgate' => [
        'driver' => 'local',
        'root' => storage_path('postisgate'),
    ],
```

Now you're ready to start using the PostisGate API Client in your application.


## Overview
Look at one of the following topics to learn more about PostisGate API Clien

* [Usage](#usage)
* [Exceptions](#exceptions)
* [Example](#example)

## Usage

The PostisGate API Client gives you the following methods to use:

### Login()

Retrieves the token for authentication when calling methods.

```php
PostisGate::login()
```

### CreateShipment()

Creates the shipment for the client order. The login command is not required. It does it automatically.

```php
PostisGate::createShipment()
```
**The `createShipment()` method will return an array of objects with: clientOrderDate, createdDate, sendType, productCategory, courierId, shipmentId, shipmentParcels[parcelReferenceId, parcelType, itemCode, itemDescription1, barCode], clientOrderId.**

### GetShipmentLabel()

Retrieve the AWB to a pdf file. The login command is not required. It does it automatically.

```php
PostisGate::getShipmentLabel()
```

**The `getShipmentLabel()` method will return TRUE.**

## Exceptions

The PostisGate package will throw exceptions if something goes wrong. This way it's easier to debug your code using the PostisGate package or to handle the error based on the type of exceptions. The PostisGate packages can throw the following exceptions:

| Exception                         | 
| ----------------------------------|
| *PostisGateInstanceException*     | 
| *PostisGateInvalidParamException* |                  
| *PostisGateTokenInvalidException* |  
| *PostisGateUnknownModelException* |  


## Example

**Login()**
```php
PostisGate::login(['name'=>'your_username', 'password'=>'your_password'])
```

**CreateShipment()**
```php
PostisGate::createShipment([
    "clientId" => "your_client_id",
    "clientOrderDate" => "2018-04-12 07:03:03",
    "clientOrderId" => "0005",
    "paymentType" => "CASH",
    "productCategory" => "Standard Delivery",
    "recipientLocation" => [
        "addressText" => "Cal. Floreasca 40",
        "contactPerson" => "Gheorghe Ion",
        "country" => "Romania",
        "county" => "Bucuresti",
        "locality" => "Bucuresti",
        "locationId" => "1",
        "name" => "Georghe Ion",
        "phoneNumber" => "0700000000",
        "postalCode" => "123456",
    ],
    "sendType" => "FORWARD",
    "senderLocation" => [
        "addressText" => "Calea Bucuresti 22, Tunari, Ilfov",
        "buildingNumber" => "22",
        "contactPerson" => "depozit",
        "country" => "Romania",
        "county" => "Ilfov",
        "locality" => "Tunari",
        "locationId" => "149",
        "name" => "Depozit central",
        "phoneNumber" => "0212210000",
        "postalCode" => "012345",
        "streetName" => "Calea Bucuresti",
    ],
    "shipmentParcels" => [[
        "itemCode" => "AB1564",
        "itemDescription1" => "product_name",
        "itemUOMCode" => "BUC",
        "parcelBrutWeight" => 20,
        "parcelDeclaredValue" => 0,
        "parcelReferenceId" => "PRE0005",
        "parcelType" => "PACKAGE",
    ]],
    "shipmentPayer" => "SENDER",
    "shipmentReference" => "SRE0005",
    "sourceChannel" => "ONLINE",
])
```

**GetShipmentLabel()**
```php
PostisGate::getShipmentLabel([
    'shipmentId' => '1234567890',
    'filename' => '0005_1234567890.pdf'
])
```

For more information use the PostisgGate API documentation.

If you want to create more operations, create a class in the `src/Operations` folder just like the existing one and call through:
```php
PostisGate::the_name_of_the_class([parameters])
```