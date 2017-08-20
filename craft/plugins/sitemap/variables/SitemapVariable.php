<?php

namespace Craft;

/**
 * Sitemap Variable
 */
class SitemapVariable
{
    /**
     * Get sitemap
     */
    public function get()
    {
        return craft()->sitemap->get();
    }

    /**
     * Get sections
     */
    public function sections()
    {
        return craft()->sitemap->getSections();
    }

    /**
     * Get category groups
     */
    public function categoryGroups()
    {
        return craft()->sitemap->getCategoryGroups();
    }

    /**
     * Get product types
     */
    public function productTypes()
    {
        return craft()->sitemap->getProductTypes();
    }

    /**
     * Get urls
     */
    public function urls()
    {
        return craft()->sitemap->getUrls();
    }

    /**
     * Get plugin urls
     */
    public function pluginUrls()
    {
        return craft()->sitemap->getPluginUrls();
    }

    /**
     * Get last ping
     */
    public function lastPing()
    {
        return craft()->sitemap->getLastPing();
    }

    /**
     * Get cache key
     */
    public function getCacheKey()
    {
        return craft()->sitemap->getCacheKey();
    }

    /**
     * Check if Commerce plugin is installed and enabled
     */
    public function isCommerceInstalled()
    {
        return craft()->sitemap->isCommerceInstalled();
    }

    /**
     * Check if site is multi locale
     */
    public function multiLocale()
    {
        return craft()->sitemap->isMultiLocale();
    }

    /**
     * Get version
     */
    public function version()
    {
        return craft()->plugins->getPlugin('sitemap')->getVersion();
    }
}
