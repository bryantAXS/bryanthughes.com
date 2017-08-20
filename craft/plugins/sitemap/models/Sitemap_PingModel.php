<?php

namespace Craft;

/**
 * Ping Model
 */
class Sitemap_PingModel extends BaseModel
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
            'urls' => AttributeType::String,
        );
    }
}
