<?php

namespace Craft;

/**
 * URL Model
 */
class Sitemap_UrlModel extends BaseModel
{
    /**
     * Defines what is returned when someone puts this directly in their template.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->url;
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
            'url' => AttributeType::String,
            'include' => AttributeType::Number,
            'changeFrequency' => AttributeType::String,
            'priority' => AttributeType::String,
        );
    }
}
