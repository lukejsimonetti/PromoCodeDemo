# PromoCodeDemo

This repo demonstrates a segment of code I've written for an online shopping cart API. 
It uses PHP 7.2, Doctrine 2 and PHPUnit.

Each class gets called from a factory and instantiated based on a config in a database. 
If the config class referenced "BOGO" the BuyOneGetOne class would be instantiated, the PromoCode entity set, and then the factory would call the `$bogoClass->apply()` function. The only argument for the `apply()` function is an array of normalized lines. See below: 

```php
[
  'catalog_item_id' => 34,
  'system' => 'event',
  'is_discount_line' => 0,
  'item_code' => 'REGISTRATION',
  'description' => 'Registration Description 1 ',
  'qty' => 1,
  'price' => 109,
  'is_alumni' => 0,
  'discount_uid' => '',
],
[
  'catalog_item_id' => 34,
  'system' => 'event',
  'is_discount_line' => 0,
  'item_code' => 'REGISTRATION',
  'description' => 'Registration Description 2',
  'qty' => 1,
  'price' => 109,
  'is_alumni' => 0,
  'discount_uid' => '',
],
[
  'catalog_item_id' => 34,
  'system' => 'event',
  'is_discount_line' => 0,
  'item_code' => 'REGISTRATION',
  'description' => 'Registration Description 3',
  'qty' => 1,
  'price' => 109,
  'is_alumni' => 0,
  'discount_uid' => '',
]
```
   
The result after applying a promo code should be a copy of the normalized lines provided by the function argument, and any additional array element prepended (if it passes the business logic specific in each promo code class). 

Since this is part of an API, there is an error function refactored out of the code that can be run independently from applying the promo code. This is useful in the event that you want to bubble up an error when applying a promo code. 
