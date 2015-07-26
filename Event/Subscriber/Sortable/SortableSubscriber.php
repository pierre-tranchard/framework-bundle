<?php
/**
 * \file SortableSubscriber.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 10/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Event\Subscriber\Sortable;

use Knp\Component\Pager\Event\BeforeEvent;
use Spark\FrameworkBundle\Event\Subscriber\Sortable\Doctrine\ArrayCollectionSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SortableSubscriber
 *
 * @package Spark\FrameworkBundle\Event\Subscriber\Sortable
 *
 * @codeCoverageIgnore
 */
class SortableSubscriber implements EventSubscriberInterface
{

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Constructor
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function before(BeforeEvent $event)
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $event->getEventDispatcher();
        $dispatcher->addSubscriber(new ArrayCollectionSubscriber($this->requestStack));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'knp_pager.before' => array('before', 1)
        );
    }
}
