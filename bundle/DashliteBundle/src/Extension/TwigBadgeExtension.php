<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Extension;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * class TwigBadgeExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class TwigBadgeExtension extends AbstractExtension
{
    public function __construct(
        private readonly TranslatorInterface $translator
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('badge', [$this, 'badge'], [
                'is_safe' => ['html'],
            ]),
            new TwigFilter('boolean', [$this, 'boolean'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function boolean(int $value): string
    {
        if (1 === $value) {
            return <<< HTML
                <span class="text-success fw-bold">OUI</span>
            HTML;
        }

        return <<< HTML
            <span class="text-danger fw-bold">NON</span>
            HTML;
    }

    public function badge(string $label, string $style = 'dim', string $state = 'primary'): string
    {
        $style = $this->badges[$label]['style'] ?? 'dim';
        $state = $this->badges[$label]['state'] ?? 'primary';
        $label = $this->translator->trans($label);

        return <<< HTML
            <span aria-label="{$label}" class="badge badge-{$style} bg-{$state}">
                {$label}
            </span>
        HTML;
    }
}
