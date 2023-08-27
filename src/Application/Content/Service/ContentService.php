<?php

declare(strict_types=1);

namespace Application\Content\Service;

use Application\Content\Command\AbstractContentCommand;
use Application\Content\Command\Blog\CreatePostCommand;
use Application\Content\Command\Blog\UpdatePostCommand;
use Application\Content\Command\Podcast\CreateEpisodeCommand;
use Application\Content\Command\Podcast\UpdateEpisodeCommand;
use Domain\Content\Entity\Blog\Post;
use Domain\Content\Enum\ContentType;
use Domain\Content\Enum\Status;
use Domain\Content\Exception\ContentScheduleDateMustBeInFutureException;
use Domain\Content\Exception\InvalidSlugException;
use Domain\Content\Repository\ContentRepositoryInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Webmozart\Assert\Assert;

/**
 * class ContentService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class ContentService
{
    public function __construct(
        private ContentRepositoryInterface $repository
    ) {
    }

    public function assertPublishableContent(AbstractContentCommand $command): void
    {
        $this->assertScheduleDateInFuture($command);
        $this->assertValidSlug($command);
        $this->assertValidDuration($command);
        $this->assertOneContentIsTopPromotedByType($command);
    }

    public function assertOneContentIsTopPromotedByType(AbstractContentCommand $command): void
    {
        if (true === $command->is_top_promoted && Status::PUBLISHED === $command->status) {
            $this->repository->resetTopPromotedContent(Post::class); // todo use correct type
        }
    }

    public function assertScheduleDateInFuture(AbstractContentCommand $command): void
    {
        if (null === $command->scheduled_at) {
            $command->scheduled_at = new \DateTimeImmutable();
        } elseif ($command->scheduled_at < new \DateTimeImmutable()) {
            throw new ContentScheduleDateMustBeInFutureException();
        }
    }

    public function assertValidDuration(AbstractContentCommand $command): void
    {
        if (0 === $command->duration) {
            /** @var CreatePostCommand|UpdatePostCommand $command */
            if (ContentType::POST === $command->content_type) {
                /*
                 * The average reading rate is actually 238, but 200 is a nice compromise and is easier to remember.
                 *
                 * Here’s the formula:
                 *
                 * Get your total word count (including the headline and subhead).
                 * Divide total word count by 200. The number before the decimal is your minutes.
                 * Take the decimal points and multiply that number by .60. That will give you your seconds.
                 *
                 * Example:
                 *
                 * 783 words ÷ 200 = 3.915 (3 = 3 minutes)
                 * .915 × .60 = .549 (a little over 54 seconds, so I’d bump it up to 60 seconds, or a full minute)
                 * reading time for this example article is 4 minutes
                 *
                 * @var CreatePostCommand|UpdatePostCommand $command
                 */
                $command->duration = intval((str_word_count((string) $command->content) / 200) * 60);
            }

            /** @var CreateEpisodeCommand|UpdateEpisodeCommand $command */
            if (ContentType::PODCAST === $command->content_type && null !== $command->audio_file) {
                $command->duration = FileMetaService::getDuration($command->audio_file->getFileInfo()->getPathname());
            }
        }
    }

    public function assertValidSlug(object $command): void
    {
        if (property_exists($command, 'name') && property_exists($command, 'slug')) {
            if (null !== $command->slug) {
                try {
                    Assert::nullOrRegex($command->slug, '/^[a-z0-9]+(?:-[a-z0-9]+)*$/');
                } catch (\Throwable $e) {
                    throw new InvalidSlugException(previous: $e);
                }
            }

            $command->slug = (new AsciiSlugger())
                ->slug(strtolower((string) $command->name), '-')
                ->toString();
        }
    }
}
