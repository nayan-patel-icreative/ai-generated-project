<?php declare(strict_types=1);

namespace Icreative\ContactPersonPlugin\Subscriber;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StorefrontSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly EntityRepository $icreativeContactPersonRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StorefrontRenderEvent::class => 'onStorefrontRender',
        ];
    }

    public function onStorefrontRender(StorefrontRenderEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');
        if (!is_string($route) || $route !== 'frontend.detail.page') {
            return;
        }

        $context = $event->getSalesChannelContext()->getContext();
        $criteria = new Criteria();
        $criteria->setLimit(5);
        $result = $this->icreativeContactPersonRepository->search($criteria, $context);

        $items = [];
        foreach ($result->getEntities() as $entity) {
            $items[] = [
                'id' => $entity->getId(),
                'name' => $entity->getName(),
                'email' => $entity->getEmail(),
                'phone' => $entity->getPhone(),
            ];
        }

        $event->setParameter('icreativeContactPersons', $items);
    }
}
