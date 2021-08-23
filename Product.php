<?php

class Product
{
    public function __construct($name, $quantity, $price, $imgURL, $imgMinURL)
    {
        $this->id = "id-" . round(microtime(true) * 1000);
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imgURL = $imgURL;
        $this->imgMinURL = $imgMinURL;
    }
}
