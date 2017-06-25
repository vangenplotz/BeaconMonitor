<?php
namespace Craft;

class BeaconMonitor_SiteModel
{
    public function __toString()
    {
        return (string)$this->name;
    }

    public function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'name' => AttributeType::String,
            'url' => AttributeType::Url,
            'secret' => AttributeType::String,
            'autoupdate' => AttributeType::Bool,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime
        );
    }

}
