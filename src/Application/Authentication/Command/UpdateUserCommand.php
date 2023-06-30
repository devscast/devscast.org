<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Devscast\Bundle\DddBundle\Application\Mapper;
use Domain\Authentication\Entity\User;
use Domain\Authentication\ValueObject\Gender;
use Domain\Authentication\ValueObject\Roles;
use Domain\Authentication\ValueObject\RssUrl;
use Domain\Shared\ValueObject\EmbeddedFile;
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
    public EmbeddedFile $avatar;

    public function __construct(
        public readonly User $_entity,
        #[Assert\NotBlank] #[Assert\Email] public ?string $email = null,
        #[Assert\NotBlank] public ?string $name = null,
        #[Assert\File(
            maxSize: '5M',
            mimeTypes: ['image/jpg', 'image/png', 'image/jpeg'],
            extensions: ['jpg', 'png', 'jpeg']
        )]
        public ?object $avatar_file = null,
        public ?string $job_title = null,
        public ?string $biography = null,
        public ?string $pronouns = null,
        public ?string $phone_number = null,
        #[Assert\Country] public ?string $country = null,
        public bool $is_subscribed_newsletter = false,
        public bool $is_subscribed_marketing = false,
        public bool $is_dark_theme = false,
        #[Assert\Url] public ?string $github_url = null,
        #[Assert\Url] public ?string $linkedin_url = null,
        #[Assert\Url] public ?string $twitter_url = null,
        #[Assert\Url] public ?string $website_url = null,
        #[Assert\Url] public ?RssUrl $rss_url = null,
    ) {
        Mapper::hydrate($this->_entity, $this);
    }
}
