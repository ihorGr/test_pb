<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Crypto\Entity\CurrencyPair;
use App\Crypto\Entity\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PriceFixtures extends Fixture
{
    private const EXCLUDED_PAIR = 'BTC-CHF';

    public function load(ObjectManager $manager): void
    {
        $pricesListByPair = [];

        foreach (CurrencyPairModel::$data as $itemPair) {

            $pairName = $itemPair['base'].'-'.$itemPair['quoted'];

            if (self::EXCLUDED_PAIR === $pairName) continue;

            for ($i = 0; $i < 24; $i++) {
                $pricesListByPair[$pairName][] = [
                    'value' => rand(2400000,3100000) / 100,
                    'time' => new \DateTimeImmutable(date('Y-m-d H:i:s', strtotime('-'.$i.' hour')))
                ];
            }
        }

        foreach ($pricesListByPair as $pairName =>  $itemPair) {
            foreach ($itemPair as $itemPrice) {
                $currencyPair = new Price();
                $currencyPair->setCurrencyPair($this->getCurrencyPair($pairName));
                $currencyPair->setValue($itemPrice['value']);
                $currencyPair->setTime($itemPrice['time']);

                $manager->persist($currencyPair);
            }
        }

        $manager->flush();
    }

    private function getCurrencyPair(string $refName): CurrencyPair
    {
        return $this->getReference(CurrencyPairFixtures::getReferenceName($refName));
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            CurrencyPairFixtures::class
        ];
    }
}
