<?php

declare(strict_types=1);

namespace Domain\Content\Enum;

/**
 * Class ContentType.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
enum ContentType: string
{
    case PODCAST = 'podcast';
    case POST = 'post';
    case VIDEO = 'video';

    public static function choices(): array
    {
        return  [
            'content.enum.content_type.post' => 'post',
            'content.enum.content_type.podcast' => 'podcast',
            'content.enum.content_type.video' => 'video',
        ];
    }

    public function getRoute(): string
    {
        return match ($this) {
            self::POST => 'app_content_blog_post_show',
            self::VIDEO => 'app_content_training_video_show',
            self::PODCAST => 'app_content_podcast_episode_show',
        };
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->value, self::choices(), true));
    }
}
