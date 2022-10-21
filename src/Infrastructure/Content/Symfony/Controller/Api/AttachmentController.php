<?php

declare(strict_types=1);

namespace Infrastructure\Content\Symfony\Controller\Api;

use Domain\Content\Entity\Attachment;
use Domain\Content\Repository\AttachmentRepositoryInterface;
use Infrastructure\Content\Doctrine\Repository\AttachmentRepository;
use Infrastructure\Shared\Symfony\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * class AttachmentController.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsController]
#[Route('/api/content/attachment', name: 'api_content_attachment_')]
final class AttachmentController extends AbstractController
{
    #[Route('/folders', name: 'folders', methods: ['GET', 'POST'])]
    public function folders(AttachmentRepositoryInterface $repository): JsonResponse
    {
        return new JsonResponse($repository->findYearsMonths());
    }

    #[Route('/files', name: 'files', methods: ['GET'])]
    public function files(AttachmentRepository $repository, Request $request): JsonResponse
    {
        ['path' => $path, 'q' => $q] = $this->getFilterParams($request);
        if (!empty($q)) {
            $attachments = $repository->search($q);
        } elseif (null === $path) {
            $attachments = $repository->findLatest();
        } else {
            $attachments = $repository->findForPath($request->get('path'));
        }

        return $this->json($attachments);
    }

    #[Route('/files/{attachment<\d+>?}', name: 'show', methods: ['POST'])]
    public function update(
        ?Attachment $attachment,
        Request $request,
        AttachmentRepositoryInterface $repository,
        ValidatorInterface $validator
    ): JsonResponse {
        [$valid, $response] = $this->validateRequest($request, $validator);
        if (!$valid) {
            return $response;
        }

        if (null === $attachment) {
            $attachment = new Attachment();
        }
        $attachment->setThumbnailFile($request->files->get('file'));
        $attachment->setCreatedAt(new \DateTime());
        $attachment->setOwner($this->getUser());
        $repository->save($attachment);

        return $this->json($attachment);
    }

    #[Route('/files/{attachment<\d+>?}', name: 'delete', methods: ['DELETE'])]
    public function delete(Attachment $attachment, AttachmentRepositoryInterface $repository): JsonResponse
    {
        $repository->delete($attachment);
        return $this->json([]);
    }

    private function getFilterParams(Request $request): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'path' => null,
            'q' => null,
        ]);
        $resolver->setAllowedTypes('path', ['string', 'null']);
        $resolver->setAllowedTypes('q', ['string', 'null']);
        $resolver->setAllowedValues('path', fn ($value) => null === $value || preg_match('/^2\d{3}\/(1[0-2]|0[1-9])$/', $value) > 0);

        try {
            return $resolver->resolve($request->query->all());
        } catch (InvalidOptionsException $exception) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }
    }

    private function validateRequest(Request $request, ValidatorInterface $validator): array
    {
        $errors = $validator->validate($request->files->get('file'), [
            new Image(),
        ]);

        if (0 === $errors->count()) {
            return [true, null];
        }

        return [false, new JsonResponse(['error' => $errors->get(0)->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY)];
    }
}
