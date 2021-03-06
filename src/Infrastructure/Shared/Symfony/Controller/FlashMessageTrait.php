<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Domain\Shared\Exception\SafeMessageException;
use Symfony\Component\Form\FormInterface;

/**
 * trait FlashMessageTrait.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
trait FlashMessageTrait
{
    protected function addSafeMessageExceptionFlash(\Throwable $e): void
    {
        if ($e instanceof SafeMessageException) {
            $message = $this->getSafeMessageException($e);
        } else {
            $message = $this->translator->trans(
                id: 'global.flashes.something_went_wrong',
                parameters: [],
                domain: 'messages'
            );
        }

        $this->logger->error($e->getMessage(), $e->getTrace());
        $this->addFlash('error', $message);
    }

    protected function getSafeMessageException(SafeMessageException $e): string
    {
        return $this->translator->trans(
            id: $e->getMessageKey(),
            parameters: $e->getMessageData(),
            domain: $e->getMessageDomain()
        );
    }

    protected function addSomethingWentWrongFlash(): void
    {
        $this->addFlash('error', $this->translator->trans(
            id: 'flashes.something_went_wrong',
            parameters: [],
            domain: 'messages'
        ));
    }

    protected function flashFormErrors(FormInterface $form): void
    {
        $errors = $this->getFormErrors($form);
        $errors = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($errors)));
        $this->addFlash(
            type: 'error',
            message: implode(separator: '\n', array: $errors)
        );
    }

    protected function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                $childErrors = $this->getFormErrors($childForm);
                if ($childErrors) {
                    $errors[] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
