<?php

namespace Craft;

/**
 * Sitemap Service
 */
class SitemapService extends BaseApplicationComponent
{

    /**
     * Get sitemap
     */
    public function get()
    {
        // set template path to our plugins templates folder
        craft()->path->setTemplatesPath(craft()->path->getPluginsPath().'sitemap/templates/');

        // render sitemap template
        $sitemap = craft()->templates->render('sitemap.xml');

        // get in raw format
        $sitemap = TemplateHelper::getRaw($sitemap);

        return $sitemap;
    }

    /**
     * Get sections from the database
     */
    public function getSections()
    {
        $sitemapSections = array();

        // get all sections
        $sections = craft()->sections->getAllSections();

        foreach ($sections as $section) {
            // get sitemap section record
            $sitemapSectionRecord = Sitemap_SectionRecord::model()->findByPk($section->id);

            // if sitemap section record exists
            if ($sitemapSectionRecord) {
                // populate model from record
                $sitemapSectionModel = Sitemap_SectionModel::populateModel($sitemapSectionRecord);
            } else {
                // populate model from section
                $sitemapSectionModel = Sitemap_SectionModel::populateModel($section);
            }

            // set attributes
            $sitemapSectionModel->name = $section->name;
            $sitemapSectionModel->hasUrls = $section->hasUrls;
            $sitemapSectionModel->urlFormat = $section->getUrlFormat();
            $sitemapSectionModel->locales = $section->getLocales();

            $sitemapSections[] = $sitemapSectionModel;
        }

        return $sitemapSections;
    }

    /**
     * Get category groups from the database
     */
    public function getCategoryGroups()
    {
        $sitemapCategoryGroups = array();

        // get all category groups
        $categoryGroups = craft()->categories->getAllGroups();

        foreach ($categoryGroups as $categoryGroup) {
            // get sitemap category group record
            $sitemapCategoryGroupRecord = Sitemap_CategoryGroupRecord::model()->findByPk($categoryGroup->id);

            // if sitemap category group record exists
            if ($sitemapCategoryGroupRecord) {
                // populate model from record
                $sitemapCategoryGroupModel = Sitemap_CategoryGroupModel::populateModel($sitemapCategoryGroupRecord);
            } else {
                // populate model from section
                $sitemapCategoryGroupModel = Sitemap_CategoryGroupModel::populateModel($categoryGroup);
            }

            // set attributes
            $sitemapCategoryGroupModel->name = $categoryGroup->name;
            $sitemapCategoryGroupModel->hasUrls = $categoryGroup->hasUrls;
            $sitemapCategoryGroupModel->locales = $categoryGroup->getLocales();

            $sitemapCategoryGroups[] = $sitemapCategoryGroupModel;
        }

        return $sitemapCategoryGroups;
    }

    /**
     * Get product types from the database
     */
    public function getProductTypes()
    {
        $sitemapProductTypes = array();

        // if commerce plugin is installed
        if ($this->isCommerceInstalled()) {
            // get all product types
            $productTypes = craft()->commerce_productTypes->getAllProductTypes();

            foreach ($productTypes as $productType) {
                // get sitemap product type record
                $sitemapProductTypeRecord = Sitemap_ProductTypeRecord::model()->findByPk($productType->id);

                // if sitemap product type record exists
                if ($sitemapProductTypeRecord) {
                    // populate model from record
                    $sitemapProductTypeModel = Sitemap_ProductTypeModel::populateModel($sitemapProductTypeRecord);
                } else {
                    // populate model from $product type
                    $sitemapProductTypeModel = Sitemap_ProductTypeModel::populateModel($productType);
                }

                // set attributes
                $sitemapProductTypeModel->name = $productType->name;
                $sitemapProductTypeModel->hasUrls = $productType->hasUrls;
                $sitemapProductTypeModel->locales = $productType->getLocales();

                if ($productType->hasUrls and isset($sitemapProductTypeModel->locales[craft()->language])) {
                    $sitemapProductTypeModel->urlFormat = $sitemapProductTypeModel->locales[craft()->language]->urlFormat;
                }

                $sitemapProductTypes[] = $sitemapProductTypeModel;
            }
        }

        return $sitemapProductTypes;
    }

    /**
     * Get urls from the database
     */
    public function getUrls()
    {
        // get urls
        $urls = Sitemap_UrlRecord::model()->findAll();

        return Sitemap_UrlModel::populateModels($urls, 'id');
    }

    /**
     * Get plugin urls from hook
     */
    public function getPluginUrls()
    {
        // create hook for other plugins to latch onto
        return craft()->plugins->call('addSitemapUrls');
    }

    /**
     * Get last ping
     */
    public function getLastPing()
    {
        $lastPing = 0;

        // get ping
        $ping = Sitemap_PingRecord::model()->find(array('order' => 'dateCreated desc'));

        if ($ping) {
            $lastPing = $ping->dateCreated;
        }

        return $lastPing;
    }

    /**
     * Get cache key
     */
    public function getCacheKey()
    {
        // generate key based on plugin version
        return 'sitemapPlugin'.craft()->plugins->getPlugin('sitemap')->getVersion();
    }

    /**
     * Check if Commerce plugin is installed and enabled
     */
    public function isCommerceInstalled()
    {
        return craft()->plugins->getPlugin('commerce', true) != null;
    }

    /**
     * Clear cached template
     */
    public function clearCachedTemplate()
    {
        // delete cache by key
        craft()->db->createCommand()->delete('templatecaches',
            array('cacheKey' => $this->getCacheKey())
        );
    }

    /**
     * Clear urls
     */
    public function clearUrls()
    {
        // delete all urls
        Sitemap_UrlRecord::model()->deleteAll();
    }

    /**
     * Is multi locale
     */
    public function isMultiLocale()
    {
        // get settings
        $settings = craft()->plugins->getPlugin('sitemap')->getSettings();

        return ($settings['multiLocale'] and count(craft()->i18n->getSiteLocales() > 1));
    }

    /**
     * Save section
     */
    public function saveSection(Sitemap_SectionModel &$sitemapSectionModel)
    {
        $sitemapSectionRecord = Sitemap_SectionRecord::model()->findByPk($sitemapSectionModel->id);

        if (!$sitemapSectionRecord) {
            $sitemapSectionRecord = new Sitemap_SectionRecord();
        }

        $sitemapSectionRecord->setAttributes($sitemapSectionModel->getAttributes(), false);

        return $sitemapSectionRecord->save();
    }

    /**
     * Save category group
     */
    public function saveCategoryGroup(Sitemap_CategoryGroupModel &$sitemapCategoryGroupModel)
    {
        $sitemapCategoryGroupRecord = Sitemap_CategoryGroupRecord::model()->findByPk($sitemapCategoryGroupModel->id);

        if (!$sitemapCategoryGroupRecord) {
            $sitemapCategoryGroupRecord = new Sitemap_CategoryGroupRecord();
        }

        $sitemapCategoryGroupRecord->setAttributes($sitemapCategoryGroupModel->getAttributes(), false);

        return $sitemapCategoryGroupRecord->save();
    }

    /**
     * Save product type
     */
    public function saveProductType(Sitemap_ProductTypeModel &$sitemapProductTypeModel)
    {
        $sitemapProductTypeRecord = Sitemap_ProductTypeRecord::model()->findByPk($sitemapProductTypeModel->id);

        if (!$sitemapProductTypeRecord) {
            $sitemapProductTypeRecord = new Sitemap_ProductTypeRecord();
        }

        $sitemapProductTypeRecord->setAttributes($sitemapProductTypeModel->getAttributes(), false);

        return $sitemapProductTypeRecord->save();
    }

    /**
     * Save url
     */
    public function saveUrl(Sitemap_UrlModel &$model)
    {
        $record = new Sitemap_UrlRecord();
        $record->setAttributes($model->getAttributes(), false);

        if ($record->save()) {
            // update id on model (for new records)
            $model->setAttribute('id', $record->getAttribute('id'));

            return true;
        } else {
            $model->addErrors($record->getErrors());

            return false;
        }
    }

    /**
     * Ping sitemap
     */
    public function pingSitemap()
    {
        // ping urls
        $pingUrls = array(
            'google' => 'http://www.google.com/webmasters/sitemaps/ping?sitemap=',
            'bing' => 'http://www.bing.com/webmaster/ping.aspx?siteMap=',
        );

        // send pings
        foreach ($pingUrls as &$url) {
            // create new guzzle client
            $client = new \Guzzle\Http\Client();

            try {
                $request = $client->get($url.UrlHelper::getSiteUrl('sitemap.xml'), array('timeout' => 5));
                $request->send();
            } catch (\Guzzle\Http\Exception\BadResponseException $e) {
            } catch (\Guzzle\Http\Exception\CurlException $e) {
            }
        }

        // save ping in database
        $record = new Sitemap_PingRecord();
        $record->urls = implode(', ', $pingUrls);
        $record->save();

        // get number of pings in table
        $count = Sitemap_PingRecord::model()->count();

        // if more than 10 rows then delete oldest ping
        if ($count > 10) {
            // delete oldest ping
            Sitemap_PingRecord::model()->find(array('order' => 'dateCreated asc'))->delete();
        }
    }

    /**
     * On save entry
     */
    public function onSaveEntry($event)
    {
        $entry = $event->params['entry'];
        $isNewEntry = $event->params['isNewEntry'];

        // if is new entry
        if ($isNewEntry) {
            // get included sections
            $sections = Sitemap_SectionRecord::model()->findAllByAttributes(array('include' => 1));
            $sections = Sitemap_SectionModel::populateModels($sections);

            $includedSections = array();

            foreach ($sections as $section) {
                $includedSections[] = $section->id;
            }

            // if entry's section is included in sitemap
            if (in_array($entry->sectionId, $includedSections)) {
                $this->pingSitemap();
            }
        }
    }

    /**
     * On save category
     */
    public function onSaveCategory($event)
    {
        $category = $event->params['category'];
        $isNewCategory = $event->params['isNewCategory'];

        // if is new category
        if ($isNewCategory) {
            // get included category groups
            $categoryGroups = Sitemap_CategoryGroupRecord::model()->findAllByAttributes(array('include' => 1));
            $categoryGroups = Sitemap_CategoryGroupModel::populateModels($categoryGroups);

            $includedCategoryGroups = array();

            foreach ($categoryGroups as $categoryGroup) {
                $includedCategoryGroups[] = $categoryGroup->id;
            }

            // if category's category group is included in sitemap
            if (in_array($category->groupId, $includedCategoryGroups)) {
                $this->pingSitemap();
            }
        }
    }

    /**
     * On save product
     */
    public function onSaveProduct($event)
    {
        $product = $event->params['product'];
        $isNewProduct = $event->params['isNewProduct'];

        // if is new product
        if ($isNewProduct) {
            // get included product types
            $productTypes = Sitemap_ProductTypeRecord::model()->findAllByAttributes(array('include' => 1));
            $productTypes = Sitemap_ProductTypeModel::populateModels($productTypes);

            $includedProductTypes = array();

            foreach ($productTypes as $productType) {
                $includedProductTypes[] = $productType->id;
            }

            // if product's product type is included in sitemap
            if (in_array($product->typeId, $includedProductTypes)) {
                $this->pingSitemap();
            }
        }
    }
}
