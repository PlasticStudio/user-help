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

use SilverStripe\SiteConfig\SiteConfig;

class HelpSidebarExtension extends Extension
{
    private static $url_segment = 'helphelphelphelp';

    private static $url_rule = '/$Action/$ID/$OtherID';

    private static $menu_priority = -1;

    private static $menu_title = 'helphelphelphelp';

    private static $menu_icon_class = 'font-icon-help-circle';

    private static $tree_class = SiteConfig::class;

    private static $required_permission_codes = array('EDIT_SITECONFIG');

    public function init()
    {
        parent::init();
        // if (class_exists(SiteTree::class)) {
        //     Requirements::javascript('silverstripe/cms: client/dist/js/bundle.js');
        // }
    }

    public function getEditForm($id = null, $fields = null)
    {
        $fields = FieldList::create();

        $fields->push(LiteralField::create('TestingHelp', "Testing Help!"));

        $form = Form::create(
            $this,
            'EditHelpForm',
            $fields,
        );

        return $form;
    }
}
