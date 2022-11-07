<?php

declare(strict_types=1);

namespace Application\Content\Command;

use Application\Shared\Command\AbstractCommand;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Domain\Authentication\Entity\User;
use Domain\Content\ValueObject\ContentStatus;
use Domain\Content\ValueObject\ContentType;
use Domain\Content\ValueObject\EducationLevel;
use Symfony\Component\HttpFoundation\File\File;

/**
 * class ContentCommand.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
abstract class AbstractContentCommand extends AbstractCommand
{
    public ContentStatus $status;
    public EducationLevel $education_level;
    public ContentType $content_type;

    public ?int $id = null;
    public ?User $owner = null;
    public ?string $name = null;
    public ?string $slug = null;
    public ?string $content = null;
    public array $tags = [];
    public array $technologies = [];
    public int $duration = 0;
    public bool $is_commentable = true;
    public bool $is_featured = false;
    public bool $is_top_promoted = false;
    public bool $is_online = false;
    public bool $is_premium = false;
    public ?\DateTimeInterface $scheduled_at = null;
    public ?File $thumbnail_file = null;

    public function setTags(array|Collection $data): self
    {
        match (true) {
            $data instanceof Collection => $data->toArray(),
            default => new ArrayCollection($data)
        };

        return $this;
    }

    public function setTechnologies(array|Collection $data): self
    {
        match (true) {
            $data instanceof Collection => $data->toArray(),
            default => new ArrayCollection($data)
        };

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
