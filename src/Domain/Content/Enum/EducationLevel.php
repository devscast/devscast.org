<?php

declare(strict_types=1);

namespace Domain\Content\Enum;

enum EducationLevel: string
{
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';

    public static function choices(): array
    {
        return  [
            'content.enum.education_level.beginner' => 'beginner',
            'content.enum.education_level.intermediate' => 'intermediate',
            'content.enum.education_level.advanced' => 'advanced',
        ];
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->value, self::choices(), true));
    }
}
