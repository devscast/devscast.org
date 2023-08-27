<?php

declare(strict_types=1);

namespace Domain\Content\Enum;

/**
 * Class Status.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
enum Status: string
{
    case DRAFT = 'draft';
    case REVIEWING = 'reviewing';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';

    public static function choices(): array
    {
        return [
            'content.enum.content_status.draft' => 'draft',
            'content.enum.content_status.reviewing' => 'reviewing',
            'content.enum.content_status.published' => 'published',
            'content.enum.content_status.rejected' => 'rejected',
        ];
    }

    public function getTranslationKey(): string
    {
        return strval(array_search($this->value, self::choices(), true));
    }
}
