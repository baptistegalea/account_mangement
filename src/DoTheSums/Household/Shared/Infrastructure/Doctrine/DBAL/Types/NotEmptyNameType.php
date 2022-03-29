<?php

declare(strict_types=1);

namespace App\DoTheSums\Household\Shared\Infrastructure\Doctrine\DBAL\Types;

use App\DoTheSums\Shared\Domain\ValueObject\NotEmptyName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class NotEmptyNameType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof NotEmptyName) {
            return $value->getValue();
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', NotEmptyName::class]
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return NotEmptyName::fromString($value);
    }

    public function getName(): string
    {
        return 'not_empty_name';
    }
}
