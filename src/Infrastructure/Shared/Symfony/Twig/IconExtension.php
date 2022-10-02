<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Twig;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Intl\Countries;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class IconExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class IconExtension extends AbstractExtension
{
    private const FLAG_PROVIDER_URL = 'https://flagcdn.com/%s/%s.png';

    private const FLAG_SIZES = ['16x12', '32x24', '64x32', '128x96', '256x192'];

    private ?Request $request;

    public function __construct(RequestStack $stack)
    {
        $this->request = $stack->getCurrentRequest();
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('devscast_icon', [$this, 'icon'], [
                'is_safe' => ['html'],
            ]),
            new TwigFunction('devscast_flag', [$this, 'flag'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    /**
     * @author bernard-ng <bernard@devscast.tech>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('icon', [$this, 'icon'], [
                'is_safe' => ['html'],
            ]),
            new TwigFilter('flag', [$this, 'flag'], [
                'is_safe' => ['html'],
            ]),
        ];
    }

    public function flag(?string $name = null, string $size = '32x24'): ?string
    {
        if (null === $name) {
            return null;
        }

        if (Countries::exists($name)) {
            if (in_array($size, self::FLAG_SIZES, true)) {
                [$width, $height] = explode('x', $size);
                $country = Countries::getName($name, $this->request?->getLocale());
                $url = sprintf(self::FLAG_PROVIDER_URL, $size, strtolower($name));

                return <<<HTML
                    <img src="${url}" width="${width}" height="${height}" alt="${country}" aria-label="${country}">
                HTML;
            }
            throw new InvalidArgumentException('Invalid size, try one of ' . implode(', ', self::FLAG_SIZES));
        }
        throw new InvalidArgumentException('Invalid country alpha 2 code');
    }

    public function icon(string $name): string
    {
        $name = Icon::get($name);

        return <<< HTML
            <em class="icon ni ni-{$name}" aria-label="icon ${name}" role="img"></em>
        HTML;
    }
}
