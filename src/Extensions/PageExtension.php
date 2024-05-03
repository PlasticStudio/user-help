<?php

namespace PlasticStudio\UserHelp\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;

/**
 * Class PageExtension
 *
 * This class is a SilverStripe data extension that adds help functionality to the Page class.
 * It adds two database fields: HelpTitle and HelpText, and modifies the CMS fields and settings fields accordingly.
 */
class PageExtension extends DataExtension
{
    private static $db = [
        'HelpTitle' => 'Varchar(255)',
        'HelpText' => 'Text'
    ];

    /**
     * Update the settings fields for the page.
     *
     * @param FieldList $fields The list of fields to update.
     * @return FieldList The updated list of fields.
     */
    public function updateSettingsFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Help', [
            TextField::create('HelpTitle', 'Help Title'),
            TextareaField::create('HelpText', 'Detailed Help')
        ]);

        return $fields;
    }

    /**
     * Update the CMS fields for the extended Page class.
     *
     * @param FieldList $fields The list of fields to update.
     * @return FieldList The updated list of fields.
     */
    public function updateCMSFields(FieldList $fields)
    {
        if (!empty($this->owner->HelpText)) {
            $fields->addFieldsToTab('Root.Help', [
                LiteralField::create(
                    'HelpTitleDisplay',
                    '<h3>' . ($this->owner->HelpTitle ?: 'No Help Title set') . '</h3>'
                ),
                LiteralField::create(
                    'HelpTextDisplay',
                    '<p>' . nl2br($this->owner->HelpText) . '</p>'
                )
            ]);
        }
        return $fields;
    }
}
