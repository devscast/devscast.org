<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\ValueObject\Roles;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class RegisterUserCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RegisterUserCommand
{
    public readonly Roles $roles;

    public function __construct(
        public ?string $name = null,
        #[Assert\NotBlank] public ?string $username = null,
        #[Assert\NotBlank] #[Assert\Email] public ?string $email = null,
        #[Assert\NotBlank] #[Assert\Length(min: 6, max: 4096)] public ?string $password = null,
        public ?string $facebook_id = null,
        public ?string $github_id = null,
        public ?string $google_id = null,
        public bool $is_subscribed_newsletter = true,
        public bool $is_subscribed_marketing = true,
        public bool $is_oauth = false,
        public ?string $oauth_type = null,
        ?Roles $roles = null,
    ) {
        $this->roles = $roles ?? Roles::developer();
    }
}
