<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 27/08/2020
 * Time: 16:13
 */

namespace CustomShippingZone\Loop;


use CustomShippingZone\Model\CustomShippingZone;
use CustomShippingZone\Model\CustomShippingZoneModules;
use CustomShippingZone\Model\CustomShippingZoneModulesQuery;
use CustomShippingZone\Model\CustomShippingZoneQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class CustomShippingZoneLoop extends BaseLoop implements PropelSearchLoopInterface
{

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('module_id'),
            Argument::createIntListTypeArgument('without_zone'),
            Argument::createAlphaNumStringTypeArgument('locale')
        );
    }

    public function buildModelCriteria()
    {
        $query = CustomShippingZoneQuery::create();

        if ($ids = $this->getId()){
            $query->filterById($ids);
        }

        if ($moduleId = $this->getmoduleId()){
            $query
                ->useCustomShippingZoneModulesQuery()
                ->filterByModuleId($moduleId)
                ->endUse();
        }

        if ($withoutZone = $this->getWithoutZone()){
            $moduleShippingZone = CustomShippingZoneModulesQuery::create()->filterByModuleId($withoutZone)->find();
            $ids = null;
            /** @var CustomShippingZoneModules $m */
            foreach ($moduleShippingZone as $m){
                $ids[] = $m->getCustomShippingZoneId();
            }
            $query->filterById( $ids,Criteria::NOT_IN);
        }

        return $query;
    }

    /**
     * @param LoopResult $loopResult
     * @return LoopResult
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function parseResults(LoopResult $loopResult)
    {
        $locale = $this->getLocale();
        /** @var CustomShippingZone $shippingZone */
        foreach ($loopResult->getResultDataCollection() as $shippingZone) {
            $loopResultRow = new LoopResultRow($shippingZone);
            $loopResultRow
                ->set("ID", $shippingZone->getId())
                ->set("TAX", $shippingZone->getTax())
                ->set("NAME", $shippingZone->setLocale($locale)->getName())
                ->set("DESCRIPTION", $shippingZone->setLocale($locale)->getDescription())
                ->set("ZIP_CODES", $shippingZone->getCustomShippingZoneZips())
            ;
            $loopResult->addRow($loopResultRow);
        }
        return $loopResult;
    }
}