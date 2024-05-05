<?php

namespace PlasticStudio\UserHelp\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use PlasticStudio\UserHelp\DataObjects\HelpContentItem;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
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
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $converter = new CommonMarkConverter([], $environment);

        // Scan the directory for Markdown files
        $files = glob($path . '*.md');

        foreach ($files as $filePath) {
            $fileName = basename($filePath, '.md');

            // Read file contents
            $content = file_get_contents($filePath);

            // Convert Markdown content to HTML
            $htmlContent = $converter->convertToHtml($content);

            // Create or update the HelpContentItem
            $helpItem = HelpContentItem::get()->find('HelpTitle', $fileName) ?: HelpContentItem::create();
            $helpItem->HelpTitle = $fileName;
            $helpItem->HelpText = $htmlContent;
            $helpItem->FromRepo = true; // assuming all files are from a repository
            $helpItem->write();

            echo "Processed '{$fileName}' into HelpContentItem.\n";
        }
    }
}
