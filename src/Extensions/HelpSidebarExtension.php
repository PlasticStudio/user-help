<?php

namespace PlasticStudio\UserHelp\Extensions;

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

class HelpSidebarExtension extends LeftAndMain
{
    private static $url_segment = 'helphelphelphelp';

    private static $url_rule = '/$Action/$ID/$OtherID';

    private static $menu_priority = -1;

    private static $menu_title = 'helphelphelphelp';

    private static $menu_icon_class = 'font-icon-help-circle';

    // private static $tree_class = SiteConfig::class;

    private static $required_permission_codes = array('EDIT_SITECONFIG');

    public function getEditForm($id = null, $fields = null)
    {
        // Create the main tab set
        $tabs = TabSet::create(
            'Root',
            $tabHelp = Tab::create('Help', LiteralField::create('TestingHelp', 'Testing Help!')),
            $tabEdit = Tab::create('Edit')
        );

        // Create a GridField configured to edit HelpContentItem data objects
        $helpContentItems = DataObject::get('HelpContentItem'); // Ensure your DataObject class name is correct
        $helpGridFieldConfig = GridFieldConfig_RecordEditor::create();
        $helpGridField = GridField::create(
            'HelpContentItems',
            'Help Content Items',
            $helpContentItems,
            $helpGridFieldConfig
        );

        // Add the GridField to the Edit tab
        $tabEdit->push($helpGridField);

        // Create the form with these fields
        $fields = FieldList::create($tabs);
        $form = Form::create(
            $this,
            'EditHelpForm',
            $fields
        );

        return $form;
    }
}
