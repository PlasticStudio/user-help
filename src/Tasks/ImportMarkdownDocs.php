<?php

namespace PlasticStudio\UserHelp\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;

class ImportMarkdownDocs extends BuildTask
{
    protected $title = 'Convert Markdown Files to HelpContentItem Entries';
    protected $description = 'Reads Markdown files from /app/docs/ and converts them into HelpContentItem dataobjects.';

    public function run($request)
    {
        // Define the path to the Markdown files relative to the base directory
        $path = Director::baseFolder() . '/app/docs/';

        // Ensure the directory exists
        if (!is_dir($path)) {
            echo "The directory does not exist.\n";
            return;
        }

        // Initialize the Markdown converter
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        // Scan the directory for Markdown files
        $files = glob($path . '*.md');

        foreach ($files as $filePath) {
            $fileName = basename($filePath, '.md');

            echo "Processing '{$fileName}'...\n";

            // Read file contents
            $content = file_get_contents($filePath);

            // Convert Markdown content to HTML
            $html = $converter->convert($content);
            $htmlContent = $html->getContent();

            // Create or update the HelpContentItem
            $helpItem = HelpContentItem::get()->find('HelpTitle', $fileName) ?: HelpContentItem::create();
            $helpItem->HelpTitle = $fileName;
            $helpItem->HelpText = $htmlContent;
            $helpItem->FromRepo = true;
            $helpItem->write();

            echo "Processed '{$fileName}' into HelpContentItem.\n";
        }
    }
}
