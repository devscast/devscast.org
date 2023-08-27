<?php

declare(strict_types=1);

namespace Domain\Content\Enum;

enum EpisodeType: string
{
    case FULL = 'Full';
    case TRAILER = 'Trailer';
    case BONUS = 'Bonus';

    public static function choices(): array
    {
        return [
            'content.enum.podcast_episode_type.full' => 'Full',
            'content.enum.podcast_episode_type.trailer' => 'Trailer',
            'content.enum.podcast_episode_type.bonus' => 'Bonus',
        ];
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->value, self::choices(), true));
    }
}
