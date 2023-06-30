<?php

declare(strict_types=1);

namespace Devscast\Bundle\DddBundle\Infrastructure\Symfony\Controller;

use Devscast\Bundle\DddBundle\Domain\Entity\HasIdentityInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * trait DeleteCsrfTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait DeleteCsrfTrait
{
    public function isDeleteCsrfTokenValid(HasIdentityInterface $entity): bool
    {
        $id = $entity->getId();
        $token = (string) $this->getCurrentRequest()->request->get('_token');

        if ($this->getCurrentRequest()->isXmlHttpRequest()) {
            /** @var array $content */
            $content = json_decode($this->getCurrentRequest()->getContent(), associative: true);
            $token = (string) $content['_token'];
        }

        return $this->isCsrfTokenValid("delete_{$id}", $token);
    }
}
