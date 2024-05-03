<?php

namespace PlasticStudio\UserHelp\Extensions;

use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\LiteralField;

class HelpSidebarExtension extends LeftAndMain
{
    public static $url_segment = 'help-admin';
    public static $url_priority = 60;
    public static $menu_title = 'Edit Public Register';
    public static $tree_class = 'PublicRegister';

    public function init()
    {
        parent::init();
        // Include custom JavaScript and CSS if necessary
        // Requirements::javascript('mysite/javascript/custom-sidebar.js');
        // Requirements::css('mysite/css/custom-sidebar.css');
    }

    public function updateEditForm($form)
    {
        // Here you can manipulate the form, e.g., add a new tab
        $form->addFieldToTab('Root.Main', LiteralField::create('MyField', 'My Field'));

    }
}
