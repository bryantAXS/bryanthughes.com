<?php

namespace Craft;

/**
 * Product Type Record
 */
class Sitemap_ProductTypeRecord extends BaseRecord
{
    /**
     * Gets the database table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'sitemap_producttypes';
    }

    /**
     * Define columns for our database table
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'include' => AttributeType::Number,
            'changeFrequency' => AttributeType::String,
            'priority' => AttributeType::String,
        );
    }
}
