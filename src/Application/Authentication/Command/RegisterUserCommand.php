<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\ValueObject\Roles;

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
        public ?string $username = null,
        public ?string $email = null,
        public ?string $password = null,
        public ?string $facebook_id = null,
        public ?string $github_id = null,
        public ?string $google_id = null,
        public bool $is_subscribed_newsletter = false,
        public bool $is_subscribed_marketing = false,
        public bool $is_oauth = false,
        public ?string $oauth_type = null,
        ?Roles $roles = null,
    ) {
        $this->roles = $roles ?? Roles::developer();
    }
}
