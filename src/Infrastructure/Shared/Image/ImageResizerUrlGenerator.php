<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Image;

use League\Glide\Urls\UrlBuilderFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Renvoie une URL redimensionnée pour une image donnée.
 */
class ImageResizerUrlGenerator
{
    /**
     * Clef permettant de signer les URLs pour le redimensionnement
     * (cf https://glide.thephpleague.com/1.0/config/security/).
     */
    private readonly string $sign_key;

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
        $this->sign_key = $_ENV['GLIDE_KEY'];
    }

    public function resize(?string $url, ?int $width = null, ?int $height = null): string
    {
        if (empty($url)) {
            return '';
        }

        if (null === $width && null === $height) {
            $url = $this->urlGenerator->generate('image_jpg', [
                'path' => trim($url, '/'),
            ]);
        } else {
            $url = $this->urlGenerator->generate('image_resizer', [
                'path' => trim($url, '/'),
                'width' => $width,
                'height' => $height,
            ]);
        }

        $urlBuilder = UrlBuilderFactory::create('/', $this->sign_key);

        return $urlBuilder->getUrl($url);
    }
}
