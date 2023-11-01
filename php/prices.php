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
    $priceTTC = number_format($priceTTC, 2);

    return $priceTTC;
}

/** 
*This function allows you to obtain the price with a promotion
* @param float  $price  price without tax
* @param float  $promotion  percent of the promotion
* @return float $promoPrice price including promotion
*/
function calculedPriceWithPromotion(float $price,float $promo){

    $discountedPrice = $price - ($price * $promo / 100);
    $promoPrice = number_format($discountedPrice, 2);

    return $promoPrice;
}