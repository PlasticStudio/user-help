<?php

namespace PlasticStudio\UserHelp\Admin;

use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\LiteralField;
use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class HelpContentAdmin extends ModelAdmin
{
    private static $managed_models = [
        HelpContentItem::class
    ];

    private static $url_segment = 'help-content';

    private static $menu_title = 'Help';

    private static $menu_icon_class = 'font-icon-help-circled';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // Add sortable helpcontentitems
        $model = singleton(HelpContentItem::class);
        $gridFieldName = $this->sanitiseClassName($model->ClassName);
        $gridField = $form->Fields()->dataFieldByName($gridFieldName);
        if ($gridField) {
            $config = $gridField->getConfig();
            $config->addComponent(new GridFieldOrderableRows('SortOrder'));
        }

        // Find or create the Root tab set
        $rootTabSet = $form->Fields()->fieldByName('Root');
        if (!$rootTabSet) {
            $rootTabSet = TabSet::create('Root');
            $form->Fields()->push($rootTabSet);
        }

        // Create a new tab with arbitrary HTML content
        $helpContent = $this->getHelpContentItems();
        $htmlTab = Tab::create(
            'CustomHTML',
            'Custom HTML',
            LiteralField::create('HelpContent', $helpContent)
        );

        // Add the new tab to the root tab set
        $rootTabSet->push($htmlTab);


        // Return the modified form
        return $form;
    }

    public function getHelpContentItems()
    {
        $html = '';
        $helpContentItems = HelpContentItem::get()->sort('SortOrder');

        // loop over each help content item and add the helpText and helpContent to the html
        foreach ($helpContentItems as $helpContentItem) {
            $html .= '<h3>' . $helpContentItem->HelpTitle . '</h3>';
            $html .= '<p>' . $helpContentItem->HelpText . '</p>';
        }

        return $html;
    }
}
