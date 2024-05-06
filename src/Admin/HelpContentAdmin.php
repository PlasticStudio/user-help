<?php

namespace PlasticStudio\UserHelp\Admin;

use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class HelpContentAdmin
 *
 * This class is a Silverstripe ModelAdmin that provides an interface for managing HelpContentItem data objects.
 */
class HelpContentAdmin extends ModelAdmin
{
    private static $menu_title = 'Help Content';

    private static $url_segment = 'help-content';

    private static $managed_models = [
        HelpContentItem::class
    ];

    private static $menu_icon_class = 'font-icon-menu-help';
}
