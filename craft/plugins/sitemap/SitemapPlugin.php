<?php

namespace Craft;

class SitemapPlugin extends BasePlugin
{
    public function init()
    {
        craft()->on('entries.saveEntry', array($this, 'onSaveEntry'));
        craft()->on('categories.saveCategory', array($this, 'onSaveCategory'));
        craft()->on('commerce_products.saveProduct', array($this, 'onSaveProduct'));
    }

    public function getName()
    {
        return Craft::t('Sitemap');
    }

    public function getVersion()
    {
        return '1.2.3';
    }

    public function getSchemaVersion()
    {
        return '1.2.0';
    }

    public function getDeveloper()
    {
        return 'PutYourLightsOn';
    }

    public function getDeveloperUrl()
    {
        return 'http://www.putyourlightson.net';
    }

    public function getDescription()
    {
        return 'Automatically creates a dynamic XML sitemap of your entire site.';
    }

    public function getDocumentationUrl()
    {
        return 'https://www.putyourlightson.net/craft-sitemap/docs';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://www.putyourlightson.net/releases/craft-sitemap';
    }

    public function hasCpSection()
    {
        return true;
    }

    protected function defineSettings()
    {
        return array(
            'enableSiteRoute' => array(AttributeType::Bool, 'required' => true, 'default' => '1'),
            'multiLocale' => array(AttributeType::Bool, 'required' => true, 'default' => '1'),
        );
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('sitemap/_settings', array(
            'settings' => $this->getSettings()
        ));
    }

    public function prepSettings($settings)
    {
        // clear cached template
        craft()->sitemap->clearCachedTemplate();

        return $settings;
    }

    public function registerSiteRoutes()
    {
        $siteRoutes = array();

        if ($this->settings['enableSiteRoute']) {
            $siteRoutes = array(
                'sitemap.xml' => array('action' => 'sitemap/get'),
            );
        }

        return $siteRoutes;
    }

    public function onSaveEntry($event)
    {
        craft()->sitemap->onSaveEntry($event);
    }

    public function onSaveCategory($event)
    {
        craft()->sitemap->onSaveCategory($event);
    }

    public function onSaveProduct($event)
    {
        craft()->sitemap->onSaveProduct($event);
    }
}
