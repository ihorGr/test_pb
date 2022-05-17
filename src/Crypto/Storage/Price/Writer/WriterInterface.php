<?php

declare(strict_types=1);

namespace App\Crypto\Storage\Price\Writer;

use App\Crypto\Storage\Price\Writer\DTO\InsertDataCollectorDto;

interface WriterInterface
{
    public function insert(InsertDataCollectorDto $dataCollectorDto): void;

    /**
     * @param InsertDataCollectorDto[] $dataCollectorDtoList
     * @return void
     */
    public function insertList(array $dataCollectorDtoList): void;
}