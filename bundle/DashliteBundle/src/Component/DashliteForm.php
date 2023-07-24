<?php

declare(strict_types=1);

namespace Devscast\Bundle\DashliteBundle\Component;

use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class Form.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent]
final class DashliteForm
{
    public FormView $form;
}
