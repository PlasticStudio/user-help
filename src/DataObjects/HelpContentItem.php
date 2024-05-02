<?php

namespace PlasticStudio\UserHelp\DataObjects;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

class HelpContentItem extends DataObject
{
    private static string $table_name = 'PSHelpContentItem';

    private static string $singular_name = 'Help Content Item';

    private static string $plural_name = 'Help Content Items';

    private static string $description = 'A single help content item';

    private static array $db = [
        'Title' => 'Varchar(255)',
        'FromRepo' => 'Boolean',
        'Content' => 'HTMLText',
        'SortOrder' => 'Int',
    ];

    private static array $has_one = [];

    // private static array $has_many $many_many = [
    //     'RelevantPages' => SiteTree::class
    // ];

    private static array $owns = [];

    private static array $summary_fields = [];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SortOrder',
            'FromRepo',
        ]);

        return $fields;
    }
}
