<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Job;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class RecentJobItem.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(name: 'RecentJobItem', template: '@app/shared/component/job/recent_job_item.html.twig')]
final class RecentJobItem
{
}
