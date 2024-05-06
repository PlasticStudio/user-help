<?php

namespace PlasticStudio\UserHelp\DataObjects;

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

use SilverStripe\Security\Permission;


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

        // Conditionally set fields as readonly based on the FromRepo value
        if ($this->FromRepo) {
            $fields->replaceField('HelpTitle', ReadonlyField::create('HelpTitle'));
            $fields->replaceField('HelpText', ReadonlyField::create('HelpText', 'Help Text', $this->HelpText)->setRows(8));
        }

        return $fields;
    }

    // mAKE TITLKE AND CONTENT REQUIRED

    public function validate()
    {
        $result = parent::validate();

        if (empty($this->HelpTitle)) {
            $result->addError('Help Title is required');
        }

        if (empty($this->HelpText)) {
            $result->addError('Help Text is required');
        }

        return $result;
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
