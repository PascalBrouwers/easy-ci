<?php

declare (strict_types=1);
namespace EasyCI20220211\Symplify\ComposerJsonManipulator\Printer;

use EasyCI20220211\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use EasyCI20220211\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use EasyCI20220211\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @api
 */
final class ComposerJsonPrinter
{
    /**
     * @var \Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    public function __construct(\EasyCI20220211\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager)
    {
        $this->jsonFileManager = $jsonFileManager;
    }
    public function printToString(\EasyCI20220211\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson) : string
    {
        return $this->jsonFileManager->encodeJsonToFileContent($composerJson->getJsonArray());
    }
    /**
     * @param \Symplify\SmartFileSystem\SmartFileInfo|string $targetFile
     */
    public function print(\EasyCI20220211\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson $composerJson, $targetFile) : string
    {
        if (\is_string($targetFile)) {
            return $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $targetFile);
        }
        return $this->jsonFileManager->printJsonToFileInfo($composerJson->getJsonArray(), $targetFile);
    }
}
