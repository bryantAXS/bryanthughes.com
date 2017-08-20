<?php

namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_migrationName
 */
class m150122_000001_sitemap_product_types_table extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public function safeUp()
    {
        $this->createTable(
            'sitemap_producttypes',
            array(
                'include' => 'integer',
                'changeFrequency' => AttributeType::String,
                'priority' => AttributeType::String,
            )
        );

        return true;
    }
}
