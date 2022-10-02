<?php

declare(strict_types=1);

namespace Tests\Domain\Authentication\ValueObject;

use Domain\Authentication\ValueObject\RssUrl;
use PHPUnit\Framework\TestCase;

/**
 * class RssUrlTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class RssUrlTest extends TestCase
{
    public function testRssFeedUrlInvalidFormat(): void
    {
        $exceptions = [];
        $invalidNames = [
            'https://devscast.tech/posts/feed',
            'http://feed.com',
            'https://feed.com/rss.html',
        ];

        foreach ($invalidNames as $name) {
            try {
                RssUrl::fromString($name);
            } catch (\InvalidArgumentException) {
                $exceptions[] = $name;
            }
        }

        $this->assertSame($invalidNames, $exceptions);
    }

    public function testSameInstanceValueAreEquals(): void
    {
        $a = RssUrl::fromString('https://devscast.tech/posts/feed.rss');
        $b = RssUrl::fromString('https://devscast.tech/posts/feed.rss');
        $this->assertSame(true, $a->equals($b));
    }

    public function testDifferentInstanceValueAreNotEquals(): void
    {
        $a = RssUrl::fromString('https://devscast.tech/posts/feed.rss');
        $b = RssUrl::fromString('https://devscast.tech/posts/feed.xml');
        $this->assertSame(false, $a->equals($b));
        $this->assertSame(false, $b->equals($a));
    }

    public function testStringValueEqualsInstanceValue(): void
    {
        $a = RssUrl::fromString('https://devscast.tech/posts/feed.rss');
        $b = 'https://devscast.tech/posts/feed.rss';
        $this->assertSame(true, $a->equals($b));
    }
}
