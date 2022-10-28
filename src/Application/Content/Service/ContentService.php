<?php

declare(strict_types=1);

namespace Application\Content\Service;

use Application\Content\Command\AbstractContentCommand;
use Domain\Content\Exception\ContentScheduleDateMustBeInFutureException;
use Domain\Content\Exception\InvalidSlugException;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Webmozart\Assert\Assert;

/**
 * class ContentService.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class ContentService
{
    public function assertScheduleDateInFuture(AbstractContentCommand $command): void
    {
        if (null === $command->scheduled_at) {
            $command->scheduled_at = new \DateTimeImmutable();
        } elseif ($command->scheduled_at < new \DateTimeImmutable()) {
            throw new ContentScheduleDateMustBeInFutureException();
        }
    }

    public function assertValidSlug(AbstractContentCommand $command): void
    {
        try {
            Assert::nullOrRegex($command->slug, '/^[a-z0-9]+(?:-[a-z0-9]+)*$/');
        } catch (\Throwable $e) {
            throw new InvalidSlugException(previous: $e);
        }

        if (null === $command->slug) {
            $command->slug = (new AsciiSlugger())->slug((string) $command->name, '-')->toString();
        }
    }
}
