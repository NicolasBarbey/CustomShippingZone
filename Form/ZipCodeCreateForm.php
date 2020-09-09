<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 24/08/2020
 * Time: 15:54
 */

namespace CustomShippingZone\Form;



use CustomShippingZone\CustomShippingZone;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Thelia\Model\Country;
use Thelia\Model\CountryQuery;

class ZipCodeCreateForm extends BaseForm
{
    protected function buildForm()
    {
        $countries = CountryQuery::create()->find();
        $choice = [];

        /** @var Country $country */
        foreach ($countries as $country){
            $choice += [
                 $country->getId() => $country->setLocale('en_US')->getTitle()
            ];
        }

        $this->formBuilder
            ->add('zip', TextType::class,[
                'required' => true,
                'label'=> Translator::getInstance()->trans(
                    'Zip code',
                    array(),
                    CustomShippingZone::DOMAIN_NAME
                ),
                'label_attr' => array(
                    'for' => 'zip'
                )
            ])
            ->add('country', ChoiceType::class,[
                'required' => true,
                'label'=> Translator::getInstance()->trans(
                    'Country',
                    array(),
                    CustomShippingZone::DOMAIN_NAME
                ),
                'label_attr' => array(
                    'for' => 'country'
                ),
                'choices' => $choice
            ]);
    }

    public function getName()
    {
        return "zip_code_create_form";
    }
}