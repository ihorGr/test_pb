<?php

declare(strict_types=1);

namespace App\DataFixtures;

class CurrencyPairModel
{
    public static $data = [
        [
            'base' => 'BTC',
            'quoted' => 'USD',
            'active' => true
        ], [
            'base' => 'BTC',
            'quoted' => 'EUR',
            'active' => true
        ], [
            'base' => 'BTC',
            'quoted' => 'GBP',
            'active' => true
        ], [
            'base' => 'BTC',
            'quoted' => 'CHF',
            'active' => false
        ],

    ];
}