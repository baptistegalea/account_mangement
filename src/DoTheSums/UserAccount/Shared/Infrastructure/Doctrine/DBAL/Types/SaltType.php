<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\Shared\Infrastructure\Doctrine\DBAL\Types;

use App\DoTheSums\UserAccount\Shared\Domain\ValueObject\Salt;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

final class SaltType extends Type
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Salt) {
            return $value->getValue();
        }

        throw ConversionException::conversionFailedInvalidType(
            $value,
            $this->getName(),
            ['null', Salt::class]
        );
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        return Salt::fromString($value);
    }

    public function getName(): string
    {
        return 'salt';
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
