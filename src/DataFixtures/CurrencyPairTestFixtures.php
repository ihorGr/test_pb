<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Crypto\Entity\CurrencyPair;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyPairTestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (CurrencyPairModel::$data as $itemPair) {
            $currencyPair = new CurrencyPair();
            $currencyPair->setBase($itemPair['base']);
            $currencyPair->setQuoted($itemPair['quoted']);
            $currencyPair->setActive($itemPair['active']);

            $manager->persist($currencyPair);

            $pairName = $itemPair['base'].'-'.$itemPair['quoted'];

            $this->addReference($this->getReferenceName($pairName), $currencyPair);
        }

        $manager->flush();
    }

    public static function getReferenceName(string $name): string
    {
        return $name;
    }
}
