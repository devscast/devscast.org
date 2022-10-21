<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Image;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * class ImageResizerTwigExtension.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
class ImageResizerExtension extends AbstractExtension
{
    public function __construct(
        private readonly ImageResizerUrlGenerator $imageResizer,
        private readonly UploaderHelper $helper
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uploads_path', [$this, 'uploadsPath']),
            new TwigFunction('image_url', [$this, 'imageUrl']),
            new TwigFunction('image_url_raw', [$this, 'imageUrlRaw']),
            new TwigFunction('image', [$this, 'imageTag'], ['is_safe' => ['html']]),
        ];
    }

    public function uploadsPath(string $path): string
    {
        return sprintf("/uploads/%s", trim($path, '/'));
    }

    public function imageUrl(?object $entity, ?int $width = null, ?int $height = null): ?string
    {
        $path = $this->helper->asset($entity);

        if (null === $path) {
            return null;
        }

        if ('jpg' !== pathinfo($path, PATHINFO_EXTENSION)) {
            return $path;
        }

        return $this->imageResizer->resize($this->helper->asset($entity), $width, $height);
    }

    public function imageUrlRaw(?object $entity): string
    {
        return $this->helper->asset($entity) ?: '';
    }

    public function imageTag(?object $entity, ?int $width = null, ?int $height = null, ?string $alt = null): ?string
    {
        $url = $this->imageUrl($entity, $width, $height);
        if (null !== $url) {
            return "<img src=\"{$url}\" width=\"{$width}\" height=\"{$height}\" alt=\"{$alt}\"/>";
        }

        return null;
    }
}
