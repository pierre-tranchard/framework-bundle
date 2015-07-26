<?php
/**
 * \file ArrayCollectionSubscriber.php
 * \author Pierre TRANCHARD <pierre@tranchard.net>
 * \version 1.0
 * \date 10/06/15
 * \brief
 * \details
 */

namespace Spark\FrameworkBundle\Event\Subscriber\Sortable\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class ArrayCollectionSubscriber
 *
 * @package Spark\FrameworkBundle\Event\Subscriber\Sortable\Doctrine
 *
 * @codeCoverageIgnore
 */
class ArrayCollectionSubscriber implements EventSubscriberInterface
{

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var string
     */
    protected $sortField;

    /**
     * @var string
     */
    protected $sortDirection;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    /**
     * Constructor
     *
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->accessor     = PropertyAccess::createPropertyAccessor();
    }

    public function items(ItemsEvent $event)
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        if (is_null($currentRequest) === false) {
            if ($event->target instanceof ArrayCollection && $event->target->count() > 1) {
                $sortFieldParameterName = $event->options['sortFieldParameterName'];
                $sortDirection          = $event->options['sortDirectionParameterName'];

                if ($currentRequest->query->has($sortFieldParameterName)) {
                    $this->sortDirection = $currentRequest->query->has($sortDirection) && strtolower(
                        $currentRequest->query->get($sortDirection)
                    ) === 'asc' ? 'asc' : 'desc';

                    $this->sortField = $currentRequest->query->get($sortFieldParameterName);

                    $data = $event->target->toArray();

                    uasort($data, array($this, "sort" . ucfirst($this->sortDirection)));

                    $event->target = new ArrayCollection($data);
                }
            }
        }
    }

    /**
     * @param $obj1
     * @param $obj2
     *
     * @return int
     */
    protected function sortAsc($obj1, $obj2)
    {
        $fieldValue1 = strtolower($this->accessor->getValue($obj1, $this->sortField));
        $fieldValue2 = strtolower($this->accessor->getValue($obj2, $this->sortField));

        if ($fieldValue1 == $fieldValue2) {
            return 0;
        }

        return ($fieldValue1 > $fieldValue2) ? +1 : -1;
    }

    /**
     * @param $obj1
     * @param $obj2
     *
     * @return int
     */
    protected function sortDesc($obj1, $obj2)
    {
        $fieldValue1 = strtolower($this->accessor->getValue($obj1, $this->sortField));
        $fieldValue2 = strtolower($this->accessor->getValue($obj2, $this->sortField));

        if ($fieldValue1 == $fieldValue2) {
            return 0;
        }

        return ($fieldValue1 > $fieldValue2) ? -1 : +1;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            'knp_pager.items' => array('items', 1)
        );
    }
}
