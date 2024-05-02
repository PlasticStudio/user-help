<?php

namespace PlasticStudio\UserHelp\Admin;

use SilverStripe\Admin\ModelAdmin;
use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

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
        $model = singleton(HelpContentItem::class);
        $gridFieldName = $this->sanitiseClassName($model->ClassName);
        $gridField = $form->Fields()->dataFieldByName($gridFieldName);
        if ($gridField) {
            $config = $gridField->getConfig();
            $config->addComponent(new GridFieldOrderableRows('SortOrder'));
        }
        return $form;
    }
}
