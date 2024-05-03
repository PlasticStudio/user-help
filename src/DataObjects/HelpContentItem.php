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
        'HelpTitle' => 'Varchar(255)',
        'HelpText' => 'HTMLText',
        'FromRepo' => 'Boolean',
        'SortOrder' => 'Int',
    ];

    private static array $has_one = [];

    // private static array $many_many = [
    // TODO: RelevantPages
    // TODO: RelevantElements
    // TODO: RelevantDataObjects
    // ];

    private static array $owns = [];

    private static array $summary_fields = [
        'HelpTitle' => 'Title',
        'Excerpt' => 'Excerpt'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'SortOrder',
            'FromRepo',
        ]);

        return $fields;
    }

    public function getExcerpt()
    {
        $content = $this->HelpText;
        if (!empty($content)) {
            $text = strip_tags($content);
            $text = preg_replace('/\s+/', ' ', $text);
            $length = 100;
            return mb_strimwidth($text, 0, $length, '...');
        }
        return '';
    }
}
