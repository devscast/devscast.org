<?php

declare(strict_types=1);

namespace Infrastructure\Administration\Symfony\Twig;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class BadgeExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class BadgeExtension extends AbstractExtension
{
    private TranslatorInterface $translator;

    private array $badges;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->badges = [
            'ROLE_ADMIN' => [
                'state' => 'danger',
            ],
            'ROLE_SUPER_ADMIN' => [
                'state' => 'danger',
            ],
            'ROLE_BUSINESS_MANAGER' => [
                'state' => 'danger',
            ],
            'ROLE_CONTENT_MANAGER' => [
                'state' => 'danger',
            ],
            'ROLE_USER' => [
                'state' => 'success',
            ],
            'draft' => [
                'state' => 'warning',
                'style' => 'dim',
            ],
            'published' => [
                'state' => 'success',
                'style' => 'dim',
            ],
            'archived' => [
                'state' => 'danger',
                'style' => 'dim',
            ],
        ];
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
                <em class="icon ni ni-check-circle-fill text-success" aria-label="icon check" role="img"></em>
            HTML;
        }

        return <<< HTML
                <em class="icon ni ni-cross-circle-fill text-danger" aria-label="icon cross" role="img"></em>
            HTML;
    }

    public function badge(string $label): string
    {
        if (array_key_exists($label, $this->badges)) {
            $style = $this->badges[$label]['style'] ?? 'dim';
            $state = $this->badges[$label]['state'] ?? 'primary';
            $label = $this->translator->trans($label);

            return <<< HTML
                <span aria-label="${label}" class="badge badge-${style} badge-outline-${state}">
                    ${label}
                </span>
            HTML;
        }

        throw new \InvalidArgumentException(sprintf('Unknown %s badge, did you forget to configure it ?', $label));
    }
}
