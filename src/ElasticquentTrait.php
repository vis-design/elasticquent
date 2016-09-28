<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 28.09.16
 * Time: 12:35
 */

namespace Vis\Elasticquent;

trait ElasticquentTrait
{
    use \Elasticquent\ElasticquentTrait;

    //ElassticSearch document fields
    public function getIndexDocumentFields()
    {
        $properties = [];
        $locale = \App::getLocale();
        foreach ($this->indexDocumentFields as $field) {
            $postfix = '';
            if ($locale != config('app.fallback_locale')) {
                $postfix = '_' . $locale;
            }
            $properties[] = $field . $postfix;
        }
        return $properties;
    }
    //ElasticSearch document data
    public function getIndexDocumentData()
    {
        $allowed = $this->getIndexDocumentFields();
        $data = array_filter(
            $this->toArray(),
            function ($key) use ($allowed) {
                return in_array($key, $allowed);
            },
            ARRAY_FILTER_USE_KEY
        );
        return $data;
    }

    //ElasticSearch index name
    function getIndexName()
    {
        return config('elastiquent.default_index') . \App::getLocale();
    }
}