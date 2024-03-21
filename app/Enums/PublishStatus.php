<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PublishStatus extends Enum
{
    const PUBLISHED = 1;
    const DRAFT = 0;

    public static function toSelectArray(): array
    {
        return [
            self::PUBLISHED => '1',
            self::DRAFT => '0',
        ];
    }

    /**
     * @param  int  $value
     * @return string
     */
    public static function description(int $value): string
    {
        return match ($value) {
            self::PUBLISHED => 'This task is published.',
            self::DRAFT => 'This task has been saved as a draft',
            default => 'No status',
        };
    }

    /**
     * @param  int  $value
     * @return string
     */
    public function label(int $value): string
    {
        return match ($value) {
            self::PUBLISHED => 'Published',
            self::DRAFT => 'Draft',
            default => '',
        };
    }

    /**
     * @param  bool  $value
     * @return bool
     */
    public function toValueBool(bool $value): bool
    {
        return match ($value) {
            true => true,
            default => false,
        };
    }
}
