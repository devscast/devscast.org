<?php

declare(strict_types=1);

namespace Application\Authentication\Command;

use Domain\Authentication\Entity\User;
use Domain\Authentication\ValueObject\Gender;
use Domain\Authentication\ValueObject\Roles;
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
        public ?string $job_title = null,
        public ?string $biography = null,
        public ?string $pronouns = null,
        public ?string $phone_number = null,
        #[Assert\Country] public ?string $country = null,
        public bool $is_subscribed_newsletter = false,
        public bool $is_subscribed_marketing = false,
    ) {
        $this->roles = Roles::fromArray($this->user->getRoles());
        $this->gender = $this->user->getGender();
        $this->email = $this->user->getEmail();
        $this->job_title = $this->user->getJobTitle();
        $this->biography = $this->user->getBiography();
        $this->pronouns = $this->user->getPronouns();
        $this->pronouns = $this->user->getPhoneNumber();
        $this->country = $this->user->getCountry();
        $this->is_subscribed_marketing = $this->user->isIsSubscribedMarketing();
        $this->is_subscribed_newsletter = $this->user->isIsSubscribedNewsletter();
    }
}
