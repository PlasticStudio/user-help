<?php

namespace PlasticStudio\UserHelp\Admin;

use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridField;
use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class HelpContentAdmin extends ModelAdmin
{
    private static $managed_models = [
        'help' => [
            'dataClass' => HelpContentItem::class,
            'title' => 'Help',
        ],
        'edit-help' => [
            'dataClass' => HelpContentItem::class,
            'title' => 'Edit',
        ],
    ];

    private static $url_segment = 'help-content';

    private static $menu_title = 'Help';

    private static $menu_icon_class = 'font-icon-help-circled';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);

        // Add sortable helpcontentitems
        // $model = singleton(HelpContentItem::class);
        // $gridFieldName = $this->sanitiseClassName($model->ClassName);
        // $gridField = $form->Fields()->dataFieldByName($gridFieldName);
        // if ($gridField) {
        //     $config = $gridField->getConfig();
        //     $config->addComponent(new GridFieldOrderableRows('SortOrder'));
        // }

        $currentModel = $this->modelClass;

        // Handling different behaviors based on the model accessed
        if ($currentModel == HelpContentItem::class && $this->getRequest()->getVar('ModelClass') == 'help') {
            // Configurations for the 'Edit Help' tab
            $gridFieldName = $this->sanitiseClassName($currentModel);
            $gridField = $form->Fields()->dataFieldByName($gridFieldName);
        }

        // Handling different behaviors based on the model accessed
        if ($currentModel == HelpContentItem::class && $this->getRequest()->getVar('ModelClass') == 'edit-help') {
            // Configurations for the 'Edit Help' tab

            $model = singleton(HelpContentItem::class);
            $gridFieldName = $this->sanitiseClassName($model->ClassName);
            $gridField = $form->Fields()->dataFieldByName($gridFieldName);
            if ($gridField) {
                $config = $gridField->getConfig();
                $config->addComponent(new GridFieldOrderableRows('SortOrder'));
            }

        }

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
