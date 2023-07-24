<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Note.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteNote
{
    public string $content;
    public string $author;
    public \DateTimeImmutable $date;
}
