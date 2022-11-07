<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\ValueObject\Gender;
use Domain\Authentication\ValueObject\Roles;
use Domain\Authentication\ValueObject\Username;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class CreateUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class CreateUserCommand
{
    public Roles $roles;
    public Gender $gender;

    public function __construct(
        #[Assert\NotBlank] public ?Username $username = null,
        #[Assert\Email] public ?string $email = null,
        public ?string $name = null,
        public ?object $avatar_file = null,
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
        public ?string $rss_url = null,
    ) {
        $this->roles = Roles::developer();
        $this->gender = Gender::queer();
    }
}
