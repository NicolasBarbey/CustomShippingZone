<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 21/08/2020
 * Time: 15:59
 */

namespace CustomShippingZone\Controller;


use CustomShippingZone\Form\CustomShippingZoneCreateForm;
use CustomShippingZone\Form\ZipCodeCreateForm;
use CustomShippingZone\Model\CustomShippingZone;
use CustomShippingZone\Model\CustomShippingZoneQuery;
use CustomShippingZone\Model\CustomShippingZoneZip;
use CustomShippingZone\Model\CustomShippingZoneZipQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\Base\CurrencyQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Tools\URL;

class CustomShippingZoneController extends BaseAdminController
{
    public function createShippingZoneAction()
    {
        $langs = LangQuery::create()->filterByActive(1)->find();
        try{
            $form = $this->validateForm(new CustomShippingZoneCreateForm($this->getRequest()));

            $shippingZone = new CustomShippingZone();

            foreach ($langs as $lang){
                $shippingZone
                    ->setTax($form->get('tax')->getData())
                    ->setLocale($lang->getLocale())
                    ->setName($form->get('name')->getData())
                    ->setDescription($form->get('description')->getData());
            }
            $shippingZone->save();

            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone"));

        }catch (\Exception $exception){
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone",[
                "err" => $exception->getMessage()
            ]));
        }
    }

    public function deleteShippingZoneAction()
    {
        $id = $this->getRequest()->get('id');

        try{
            $shippingZone = CustomShippingZoneQuery::create()->findOneById($id);
            foreach ($shippingZone->getCustomShippingZoneZips() as $zip){
                $zip->delete();
            }
            $shippingZone->delete();
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone"));
        }catch (\Exception $exception) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone", [
                "err" => $exception->getMessage()
            ]));
        }
    }

    public function updateShippingZoneAction()
    {
        $id = $this->getRequest()->get("id");
        $shippingZone = CustomShippingZoneQuery::create()->findOneById($id);
        /** @var Lang $lang */
        $lang = $this->getSession()->get("thelia.admin.edition.lang");
        try{
            $form = $this->validateForm(new CustomShippingZoneCreateForm($this->getRequest()));

            $shippingZone
                ->setTax($form->get('tax')->getData())
                ->setLocale($lang->getLocale())
                ->setName($form->get('name')->getData())
                ->setDescription($form->get('description')->getData())
                ->save();

            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone/edit/$id", [
                "edit_language_id" => $lang->getId()
            ]));
        }catch (\Exception $exception){
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone/edit/$id", [
                "err" => $exception->getMessage(),
                "edit_language_id" => $lang->getId()
            ]));
        }
    }

    public function createZipShippingZoneAction()
    {
        $lang = $this->getSession()->get("thelia.admin.edition.lang");
        $id = $this->getRequest()->get("id");
        try{
            $shippingZone = CustomShippingZoneQuery::create()->findOneById($id);
            $form = $this->validateForm(new ZipCodeCreateForm($this->getRequest()));
            $zip = (new CustomShippingZoneZip())
                ->setZipCode($form->get("zip")->getData())
                ->setCountryId($form->get("country")->getData());
            $shippingZone->addCustomShippingZoneZip($zip)->save();
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone/edit/$id",[
                "edit_language_id" => $lang->getId()
            ]));
        }catch (\Exception $exception){
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone/edit/$id", [
                "err" => $exception->getMessage(),
                "edit_language_id" => $lang->getId()
            ]));
        }
    }

    public function deleteZipShippingZoneAction()
    {
        $lang = $this->getSession()->get("thelia.admin.edition.lang");
        $zip = CustomShippingZoneZipQuery::create()->findOneById($this->getRequest()->get("zipId"));
        $id = $zip->getCustomShippingZoneId();
        try{
            $zip->delete();
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone/edit/$id",[
                "edit_language_id" => $lang->getId()
            ]));
        }catch (\Exception $exception) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl("/admin/module/CustomShippingZone/edit/$id", [
                "err" => $exception->getMessage(),
                "edit_language_id" => $lang->getId()
            ]));
        }
    }

    /**
     * @return \Thelia\Core\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function renderShippingZonePageAction()
    {
        $defaultLang = LangQuery::create()->findOneByByDefault(1);
        $locale = $defaultLang->getLocale();
        if ($langId = $this->getRequest()->get('edit_language_id')){
            $locale = LangQuery::create()->findOneById($langId)->getLocale();
        }
        $id = $this->getRequest()->get('id');
        $shippingZone = CustomShippingZoneQuery::create()->findOneById($id);

        $zipCodes = $shippingZone->getCustomShippingZoneZips();

        $defaultCurrency = CurrencyQuery::create()->filterByByDefault(1)->findOne();
        $currencies = CurrencyQuery::create()->filterByVisible(1)->filterByByDefault(0)->find()->toArray();

        return $this->render('CustomShippingZoneEdit', [
            'shippingZoneName' => $shippingZone->setLocale($locale)->getName(),
            'shippingZoneDescription' => $shippingZone->setLocale($locale)->getDescription(),
            'shippingZoneId' => $shippingZone->getId(),
            'shippingZoneTax' => $shippingZone->getTax(),
            'zipCodes' => $zipCodes,
            'edit_language_id' => $langId ? : $defaultLang->getId(),
            'defaultCurrency' => $defaultCurrency,
            'currencies' => $currencies,
            "err" => $this->getRequest()->get('err')
        ], 200);
    }
}

