<?php

namespace Craft;

/**
 * URL Record
 *
 * Provides a definition of the database tables required by our plugin,
 * and methods for updating the database. This class should only be called
 * by our service layer, to ensure a consistent API for the rest of the
 * application to use.
 */
class Sitemap_UrlRecord extends BaseRecord
{
    /**
     * Gets the database table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'sitemap_urls';
    }

    /**
     * Define columns for our database table
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'url' => array(AttributeType::String, 'required' => true),
            'include' => array(AttributeType::Number),
            'changeFrequency' => array(AttributeType::String),
            'priority' => array(AttributeType::String),
        );
    }
}
