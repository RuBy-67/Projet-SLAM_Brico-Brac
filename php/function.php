<?php
/** 
*This function allows you to obtain the price including tax of an item.
* @param float  $price  price without tax
* @param float  $tva  percent of the tax
* @return float $priceWithTax price including tax
*/
function calculedPriceWithTva(float $price,float $tva):float{
    if ($price < 0 || $tva < 0) {
        //? Check if value are positives
        return "Les valeurs doivent être positives.";
    }
    $priceTTC = $price + ($price * ($tva / 100));

    return $priceTTC;
}