<?php

namespace PlasticStudio\UserHelp\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use Parsedown;

class ImportMarkdownDocs extends BuildTask
{
    protected $title = 'Convert Markdown Files to HelpContentItem Entries';

    protected $description = 'Reads Markdown files from /assets/docs/ and converts them into HelpContentItem dataobjects.';

    public function run($request)
    {
        // Ensure the parsedown library is loaded
        $parsedown = new Parsedown();

        // Define the path to the Markdown files
        $path = ASSETS_PATH . '/docs/';
        $folder = Folder::find_or_make('/docs');

        // Fetch all Markdown files in the specified directory
        $files = File::get()->filter([
            'ParentID' => $folder->ID,
            'Extension' => 'md'
        ]);

        foreach ($files as $file) {
            // Read file contents
            $content = file_get_contents($file->getFullPath());

            // Convert Markdown content to HTML
            $htmlContent = $parsedown->text($content);

            // Create or update the HelpContentItem
            $helpItem = HelpContentItem::get()->find('HelpTitle', $file->Title) ?: HelpContentItem::create();
            $helpItem->HelpTitle = $file->Title;
            $helpItem->HelpText = $htmlContent;
            $helpItem->FromRepo = true; // assuming all files are from a repository
            $helpItem->write();

            echo "Processed '{$file->Title}' into HelpContentItem.\n";
        }
    }
}
