<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Symfony\Controller;

use Domain\Shared\Exception\SafeMessageException;
use Symfony\Component\Form\FormError;
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
        $message = $this->getSafeMessageException($e);
        $this->logger->error($e->getMessage(), $e->getTrace());
        $this->addFlash('error', $message);
    }

    protected function addSafeMessageExceptionError(\Throwable $e): FormError
    {
        return new FormError($this->getSafeMessageException($e));
    }

    protected function getSafeMessageException(\Throwable $e): string
    {
        $previous = $e->getPrevious();

        return match (true) {
            $previous instanceof SafeMessageException => $this->translator->trans(
                id: $previous->getMessageKey(),
                parameters: $previous->getMessageData(),
                domain: $previous->getMessageDomain()
            ),
            $e instanceof SafeMessageException => $this->translator->trans(
                id: $e->getMessageKey(),
                parameters: $e->getMessageData(),
                domain: $e->getMessageDomain()
            ),
            default => $this->translator->trans(
                id: 'global.flashes.something_went_wrong',
                parameters: [],
                domain: 'messages'
            )
        };
    }

    protected function addSomethingWentWrongFlash(): void
    {
        $this->addFlash('error', $this->translator->trans(
            id: 'global.flashes.something_went_wrong',
            parameters: [],
            domain: 'messages'
        ));
    }

    protected function addSuccessfullActionFlash(?string $action = null): void
    {
        $this->addFlash('success', $this->translator->trans(
            id: 'global.flashes.action_done_successfully',
            parameters: [
                '%action%' => $action ?? "l'action",
            ],
            domain: 'messages'
        ));
    }

    protected function addSuccessFlash(string $id, array $parameters = [], ?string $domain = null): void
    {
        $this->addFlash('success', $this->translator->trans(
            id: $id,
            parameters: $parameters,
            domain: $domain ?? 'messages'
        ));
    }

    protected function addErrorFlash(string $id, array $parameters = [], ?string $domain = null): void
    {
        $this->addFlash('error', $this->translator->trans(
            id: $id,
            parameters: $parameters,
            domain: $domain ?? 'messages'
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
