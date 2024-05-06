<?php

namespace PlasticStudio\UserHelp\Extensions;

use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\LiteralField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Versioned\RecursivePublishable;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldConfig;

// Modeladmin:
// A: http://localhost/admin/help-content/PlasticStudio-UserHelp-DataObjects-HelpContentItem/EditForm/field/PlasticStudio-UserHelp-DataObjects-HelpContentItem/item/new
// E: http://localhost/admin/help-content/PlasticStudio-UserHelp-DataObjects-HelpContentItem/EditForm/field/PlasticStudio-UserHelp-DataObjects-HelpContentItem/item/7/edit


// LAM:
// A: http://localhost/admin/help/EditHelpForm/field/HelpContentItems/item/new
// E: http://localhost/admin/help/EditHelpForm/field/HelpContentItems/item/7/edit

class HelpSidebarExtension extends LeftAndMain
{
    private static $url_segment = 'help';

    private static $url_rule = '/$Action/$ID/$OtherID';

    private static $menu_priority = -1;

    private static $menu_title = 'Help';

    private static $menu_icon_class = 'font-icon-help-circle';

    // add allowed action
    private static $allowed_actions = array(
        // 'handleItem',
        'EditHelpForm'
    );

    // private static $tree_class = SiteConfig::class;

    private static $required_permission_codes = array('EDIT_SITECONFIG');

    public function getEditForm($id = null, $fields = null)
    {
        $fields = FieldList::create();

        $fields->addFieldToTab('Root.Help', LiteralField::create('HelpContent', $this->renderAllHelpItems()));

        // Create a GridField configured to edit HelpContentItem data objects
        $helpContentItems = HelpContentItem::get();
        $helpGridFieldConfig = GridFieldConfig_RecordEditor::create();
        $helpGridField = GridField::create(
            'HelpContentItems',
            'Help Content Items',
            $helpContentItems,
            $helpGridFieldConfig
        );

        $fields->addFieldToTab('Root.Edit', $helpGridField);

        $form = Form::create(
            $this,
            'EditHelpForm',
            $fields
        )->setHTMLID('Form_EditForm');
        $form->addExtraClass('cms-content center cms-edit-form');

        if($form->Fields()->hasTabset()) {
            $form->Fields()->findOrMakeTab('Root')->setTemplate('CMSTabSet');
        }
        $form->setHTMLID('Form_EditForm');
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));

        return $form;
    }

    public function renderAllHelpItems()
    {
        $helpItems = HelpContentItem::get()->sort('SortOrder');
        $html = '';
        foreach ($helpItems as $helpItem) {
            $html .= '<h2>' . $helpItem->HelpTitle . '</h2>';
            $html .= $helpItem->HelpText;
        }

        return $html;
    }

    // public function handleItem($request)
    // {
    //     return $this->getEditForm()->Fields()->dataFieldByName('HelpContentItems')->handleRequest($request, DataModel::inst());
    // }
}
