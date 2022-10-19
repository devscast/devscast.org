<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Image;

use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Signatures\SignatureFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * class ImageController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
class ImageResizerController
{
    private readonly string $cache_path;
    private readonly string $resize_key;
    private readonly string $public_path;

    public function __construct(string $projectDir)
    {
        $this->cache_path = sprintf("%s/var/images", $projectDir);
        $this->public_path = sprintf("%s/public", $projectDir);
        $this->resize_key = $_ENV['GLIDE_KEY'];
    }

    /**
     * @Route("/media/resize/{width}/{height}/{path}", requirements={"width"="\d+", "height"="\d+", "path"=".+"}, name="image_resizer")
     */
    public function image(int $width, int $height, string $path, Request $request): Response
    {
        $server = ServerFactory::create([
            'source' => $this->public_path,
            'cache' => $this->cache_path,
            'driver' => 'imagick',
            'response' => new ImageResizerResponseFactory(),
            'defaults' => [
                'q' => 75,
                'fm' => 'jpg',
                'fit' => 'crop',
            ],
        ]);
        [$url] = explode('?', $request->getRequestUri());
        try {
            SignatureFactory::create($this->resize_key)->validateRequest($url, ['s' => $request->get('s')]);

            return $server->getImageResponse($path, ['w' => $width, 'h' => $height, 'fit' => 'crop']);
        } catch (SignatureException) {
            throw new HttpException(403, 'Signature invalide');
        }
    }

    /**
     * @Route("/media/convert/{path}", requirements={"path"=".+"}, name="image_jpg")
     */
    public function convert(string $path, Request $request): Response
    {
        $server = ServerFactory::create([
            'source' => $this->public_path,
            'cache' => $this->cache_path,
            'driver' => 'imagick',
            'response' => new ImageResizerResponseFactory(),
            'defaults' => [
                'q' => 75,
                'fm' => 'jpg',
                'fit' => 'crop',
            ],
        ]);
        [$url] = explode('?', $request->getRequestUri());
        try {
            SignatureFactory::create($this->resize_key)->validateRequest($url, ['s' => $request->get('s')]);

            return $server->getImageResponse($path, ['fm' => 'jpg']);
        } catch (SignatureException) {
            throw new HttpException(403, 'Signature invalide');
        }
    }
}
