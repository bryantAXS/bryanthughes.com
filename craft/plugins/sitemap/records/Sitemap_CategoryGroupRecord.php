<?php

namespace Craft;

/**
 * Category Group Record
 *
 * Provides a definition of the database tables required by our plugin,
 * and methods for updating the database. This class should only be called
 * by our service layer, to ensure a consistent API for the rest of the
 * application to use.
 */
class Sitemap_CategoryGroupRecord extends BaseRecord
{
    /**
     * Gets the database table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'sitemap_categorygroups';
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

    /**
     * Define table relations
     */
    public function defineRelations()
    {
        return array(
            'categoryGroup'  => array(static::BELONGS_TO, 'CategoryGroupRecord', 'id', 'required' => true, 'onDelete' => static::CASCADE),
        );
    }
}
