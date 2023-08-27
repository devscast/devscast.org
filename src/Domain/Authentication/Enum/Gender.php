<?php

declare(strict_types=1);

namespace Domain\Authentication\Enum;

/**
 * Class Gender.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
enum Gender: string
{
    case MASCULINE = 'M';
    case FEMININE = 'F';
    case OTHER = 'O';

    public static function choices(): array
    {
        return [
            'authentication.value_object.gender.masculine' => 'M',
            'authentication.value_object.gender.feminine' => 'F',
            'authentication.value_object.gender.other' => 'O',
        ];
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->value, self::choices(), true));
    }
}
