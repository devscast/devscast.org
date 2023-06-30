<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Twig;

use Parsedown;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * class TwigMailerExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class TwigMailerExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('markdown_email', [$this, 'markdown'], [
                'needs_context' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFilter('text_email', [$this, 'text']),
        ];
    }

    public function markdown(array $context, string $content): string
    {
        if (($context['_format'] ?? 'text') === 'text') {
            return $content;
        }
        $content = preg_replace('/^(^ {2,})(\S+[ \S]*)$/m', '${2}', $content);

        return (new Parsedown())->setSafeMode(false)->text($content);
    }

    public function text(string $content): string
    {
        $content = strip_tags($content);
        $content = preg_replace('/^(^ {2,})(\S+[ \S]*)$/m', '${2}', $content) ?: '';

        return preg_replace("/([\r\n] *){3,}/", "\n\n", $content) ?: '';
    }
}
