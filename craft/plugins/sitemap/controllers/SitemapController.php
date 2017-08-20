<?php

namespace Craft;

/**
 * Sitemap Controller
 */
class SitemapController extends BaseController
{
    protected $allowAnonymous = array('actionGet');

    /**
     * Get sitemap
     */
    public function actionGet()
    {
        // set template path to our plugins templates folder
        craft()->templates->setTemplatesPath(craft()->path->getPluginsPath().'sitemap/templates/');

        // render sitemap template
        $this->renderTemplate('sitemap.xml');
    }

    /**
     * Save sitemap
     */
    public function actionSaveSitemap()
    {
        $this->requirePostRequest();

        // get sections
        $sections = craft()->request->getPost('sections', array());

        // get category groups
        $categoryGroups = craft()->request->getPost('categoryGroups', array());

        // get product types
        $productTypes = craft()->request->getPost('productTypes', array());

        // get urls
        $urls = craft()->request->getPost('urls', array());

        $errors = false;

        // save sections
        foreach ($sections as $section) {
            $model = new Sitemap_SectionModel();
            $model->setAttributes($section);

            if (!craft()->sitemap->saveSection($model)) {
                $errors = true;
            }
        }

        // save category groups
        foreach ($categoryGroups as $categoryGroup) {
            $model = new Sitemap_CategoryGroupModel();
            $model->setAttributes($categoryGroup);

            if (!craft()->sitemap->saveCategoryGroup($model)) {
                $errors = true;
            }
        }

        // save product types
        foreach ($productTypes as $productType) {
            $model = new Sitemap_ProductTypeModel();
            $model->setAttributes($productType);

            if (!craft()->sitemap->saveProductType($model)) {
                $errors = true;
            }
        }

        // clear urls
        craft()->sitemap->clearUrls();

        // save urls
        foreach ($urls as $url) {
            $model = new Sitemap_UrlModel();
            $model->setAttributes($url);

            if (!craft()->sitemap->saveUrl($model)) {
                $errors = true;
            }
        }

        // check if we should ping sitemap
        if (craft()->request->getPost('ping')) {
            craft()->sitemap->pingSitemap();
        }

        // clear cached template
        craft()->sitemap->clearCachedTemplate();

        if ($errors) {
            craft()->userSession->setError(Craft::t('Couldn\'t save sitemap.'));
        } elseif (craft()->request->getPost('ping')) {
            craft()->userSession->setNotice(Craft::t('Sitemap saved and pinged.'));
        } else {
            craft()->userSession->setNotice(Craft::t('Sitemap saved.'));

            return $this->redirectToPostedUrl();
        }
    }
}
