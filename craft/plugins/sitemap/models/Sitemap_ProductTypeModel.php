<?php

namespace Craft;

/**
 * Product Type Model
 */
class Sitemap_ProductTypeModel extends BaseModel
{
    /**
     * Defines what is returned when someone puts this directly in their template.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Define the attributes this model will have.
     *
     * @return array
     */
    public function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'include' => AttributeType::Number,
            'changeFrequency' => AttributeType::String,
            'priority' => AttributeType::String,
            'name' => AttributeType::String,
            'handle' => AttributeType::String,
            'hasUrls' => AttributeType::Bool,
            'urlFormat' => AttributeType::String,
            'locales' => AttributeType::Mixed,
        );
    }
}
