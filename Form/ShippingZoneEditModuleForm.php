<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 27/08/2020
 * Time: 09:12
 */

namespace CustomShippingZone\Form;


use CustomShippingZone\CustomShippingZone;
use CustomShippingZone\Model\CustomShippingZone as CustomShippingZoneModel;
use CustomShippingZone\Model\CustomShippingZoneQuery;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ShippingZoneEditModuleForm extends BaseForm
{
    protected function buildForm()
    {
        $locale = $this->getRequest()->getSession()->getLang()->getLocale();
        $shippingZones = CustomShippingZoneQuery::create()->find();
        $choices = null;
        /** @var CustomShippingZoneModel $shippingZone */
        foreach ($shippingZones as $shippingZone){
            $choices[$shippingZone->getId()] = $shippingZone->setLocale($locale)->getName();
        }

        $this->formBuilder
            ->add('select_zone', ChoiceType::class, [
                'required' => true,
                'label'=> Translator::getInstance()->trans(
                    'Custom shipping zones',
                    array(),
                    CustomShippingZone::DOMAIN_NAME
                ),
                'label_attr' => array(
                    'for' => 'select_zone'
                ),
                'choices' => $choices
            ]);
    }

    public function getName()
    {
        return 'shipping_zone_edit_module_form';
    }
}