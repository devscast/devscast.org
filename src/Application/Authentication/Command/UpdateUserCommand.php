<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Application\Shared\Mapper;
use Domain\Authentication\Entity\User;
use Domain\Authentication\ValueObject\Gender;
use Domain\Authentication\ValueObject\Roles;
use Domain\Authentication\ValueObject\RssUrl;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UpdateUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class UpdateUserCommand
{
    public Roles $roles;
    public Gender $gender;

    public function __construct(
        public readonly User $user,
        #[Assert\Email] public ?string $email = null,
        public ?string $name = null,
        #[Assert\File(
            maxSize: '2M',
            mimeTypes: ['image/jpg', 'image/jpeg', 'image/png']
        )] public ?object $avatar_file = null,
        public ?string $job_title = null,
        public ?string $biography = null,
        public ?string $pronouns = null,
        public ?string $phone_number = null,
        #[Assert\Country] public ?string $country = null,
        public bool $is_subscribed_newsletter = false,
        public bool $is_subscribed_marketing = false,
        public bool $is_dark_theme = false,
        public ?string $github_url = null,
        public ?string $linkedin_url = null,
        public ?string $twitter_url = null,
        public ?string $website_url = null,
        public ?RssUrl $rss_url = null,
    ) {
        Mapper::hydrate($this->user, $this);
    }
}
