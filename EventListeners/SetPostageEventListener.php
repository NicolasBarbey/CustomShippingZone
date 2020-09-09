<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 28/08/2020
 * Time: 14:11
 */

namespace CustomShippingZone\EventListeners;


use CustomShippingZone\Model\Base\CustomShippingZoneModules;
use CustomShippingZone\Model\CustomShippingZoneModulesQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Model\AddressQuery;

class SetPostageEventListener implements EventSubscriberInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param OrderEvent $event
     * @return OrderEvent
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setPostage(OrderEvent $event)
    {
        $deliveryModule = $event->getDeliveryModule();

        $address = AddressQuery::create()->findOneById($event->getDeliveryAddress());

        $rate = $this->getRequest()->getSession()->getCurrency()->getRate();

        if (!$shippingZoneModule = CustomShippingZoneModulesQuery::create()->filterByModuleId($deliveryModule)->find()->getData()){
            return $event;
        }

        /** @var CustomShippingZoneModules $zoneModule */
        foreach ($shippingZoneModule as $zoneModule){
            $zipCodes = $zoneModule->getCustomShippingZone()->getCustomShippingZoneZips();

            foreach ($zipCodes as $zipCode){
                if ($zipCode->getZipCode() === $address->getZipcode() && $zipCode->getCountryId() === $address->getCountryId()){
                    $event->getOrder()->setPostage($event->getPostage() + ($zoneModule->getCustomShippingZone()->getTax() * $rate));
                    break;
                }
            }
        }

        return $event;
    }


    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::ORDER_SET_POSTAGE => array('setPostage', 128)
        );
    }

}