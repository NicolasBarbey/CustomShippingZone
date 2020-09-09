<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 21/08/2020
 * Time: 11:15
 */

namespace CustomShippingZone\Hook;


use CustomShippingZone\Model\Base\CustomShippingZoneModules;
use CustomShippingZone\Model\CustomShippingZone;
use CustomShippingZone\Model\CustomShippingZoneModulesQuery;
use CustomShippingZone\Model\CustomShippingZoneQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\Currency;
use Thelia\Model\CurrencyQuery;
use Thelia\Tools\MoneyFormat;

class BackHook extends BaseHook
{
    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $currency = CurrencyQuery::create()->filterByByDefault(1)->findOne();


        $event->add($this->render('CustomShippingZoneConfig.html',[
            'SYMBOL' => $currency->getSymbol()
        ]));
    }

    /**
     * @param HookRenderEvent $event
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function onShippingZonesEditBottom(HookRenderEvent $event)
    {
        $lang = $this->getSession()->getLang()->getLocale();
        $moduleId = $event->getArgument('delivery_module_id');
        $shippingZoneModule = CustomShippingZoneModulesQuery::create()->filterByModuleId($moduleId);
        $result = null;

        /** @var CustomShippingZoneModules $szm */
        foreach ($shippingZoneModule as $szm){
            $shippingZone = $szm->getCustomShippingZone();
            $result[] = [
                'id' => $shippingZone->getId(),
                'name' => $shippingZone->setLocale($lang)->getName(),
                'tax' => MoneyFormat::getInstance($this->getRequest())->formatByCurrency($shippingZone->getTax()),
                'shippingToModuleId' => $szm->getId()
            ];
        }

        $event->add($this->render('hook/ShippingZoneEditBottom.html', [
            'shipping_zones' => $result
        ]));

    }
}