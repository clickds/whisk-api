<?php

namespace ClickDs\WhiskApi\Actions;

trait ShoppingBasket
{
    /**
     * Convert To Basket
     *
     * @return mixed
     */
    public function convertToShoppingBasket(array $params)
    {
        $uri = '/v1/lists/transfers';

        return $this->post($uri, $params);
    }
}
