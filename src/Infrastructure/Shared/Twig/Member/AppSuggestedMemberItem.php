<?php

declare(strict_types=1);

namespace Infrastructure\Shared\Twig\Member;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

/**
 * Class AppSuggestedMemberItem.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
#[AsTwigComponent(template: '@app/shared/component/member/suggested_member_item.html.twig')]
final class AppSuggestedMemberItem
{
}
