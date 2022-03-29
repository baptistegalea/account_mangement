<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Infrastructure\Doctrine\DBAL\Types;

use App\DoTheSums\Household\Shared\Domain\ValueObject\Amount;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class AmountType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getFloatDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Amount) {
            return $value->getValue();
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', Amount::class]
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if (\is_string($value)) {
            $value = (float) $value;
        }
        return Amount::fromFloat($value);
    }

    public function getName(): string
    {
        return 'amount';
    }
}
