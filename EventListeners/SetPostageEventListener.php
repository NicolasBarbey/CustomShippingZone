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
use Thelia\Core\Event\Delivery\DeliveryPostageEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;


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
     * @param DeliveryPostageEvent $event
     * @return DeliveryPostageEvent
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setModuleDeliveryPostage(DeliveryPostageEvent $event)
    {
        $deliveryModule = $event->getModule();

        $address = $event->getAddress();

        $rate = $this->getRequest()->getSession()->getCurrency()->getRate();

        if (!$shippingZoneModule = CustomShippingZoneModulesQuery::create()->filterByModuleId($deliveryModule->getModuleModel()->getId())->find()->getData()){
            return $event;
        }

        /** @var CustomShippingZoneModules $zoneModule */
        foreach ($shippingZoneModule as $zoneModule){
            $zipCodes = $zoneModule->getCustomShippingZone()->getCustomShippingZoneZips();

            foreach ($zipCodes as $zipCode){
                if ($zipCode->getZipCode() === $address->getZipcode() && $zipCode->getCountryId() === $address->getCountryId()){
                    $event->setPostage($event->getPostage()->getAmount() + ($zoneModule->getCustomShippingZone()->getTax() * $rate));
                    break;
                }
            }
        }

        return $event;
    }


    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::MODULE_DELIVERY_GET_POSTAGE => array('setModuleDeliveryPostage')
        );
    }

}