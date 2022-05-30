<?php

declare (strict_types=1);
namespace EasyCI20220530\Symplify\VendorPatches\Composer;

use EasyCI20220530\Symplify\Astral\Exception\ShouldNotHappenException;
use EasyCI20220530\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use EasyCI20220530\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use EasyCI20220530\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use EasyCI20220530\Symplify\PackageBuilder\Yaml\ParametersMerger;
use EasyCI20220530\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\VendorPatches\Tests\Composer\ComposerPatchesConfigurationUpdater\ComposerPatchesConfigurationUpdaterTest
 */
final class ComposerPatchesConfigurationUpdater
{
    /**
     * @var \Symplify\ComposerJsonManipulator\ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var \Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager
     */
    private $jsonFileManager;
    /**
     * @var \Symplify\PackageBuilder\Yaml\ParametersMerger
     */
    private $parametersMerger;
    public function __construct(\EasyCI20220530\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory, \EasyCI20220530\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager $jsonFileManager, \EasyCI20220530\Symplify\PackageBuilder\Yaml\ParametersMerger $parametersMerger)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->jsonFileManager = $jsonFileManager;
        $this->parametersMerger = $parametersMerger;
    }
    /**
     * @param mixed[] $composerExtraPatches
     */
    public function updateComposerJson(string $composerJsonFilePath, array $composerExtraPatches) : \EasyCI20220530\Symplify\ComposerJsonManipulator\ValueObject\ComposerJson
    {
        $extra = ['patches' => $composerExtraPatches];
        $composerJson = $this->composerJsonFactory->createFromFilePath($composerJsonFilePath);
        // merge "extra" section - deep merge is needed, so original patches are included
        $newExtra = $this->parametersMerger->merge($composerJson->getExtra(), $extra);
        $composerJson->setExtra($newExtra);
        return $composerJson;
    }
    /**
     * @param mixed[] $composerExtraPatches
     */
    public function updateComposerJsonAndPrint(string $composerJsonFilePath, array $composerExtraPatches) : void
    {
        $composerJson = $this->updateComposerJson($composerJsonFilePath, $composerExtraPatches);
        $fileInfo = $composerJson->getFileInfo();
        if (!$fileInfo instanceof \EasyCI20220530\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \EasyCI20220530\Symplify\Astral\Exception\ShouldNotHappenException();
        }
        $this->jsonFileManager->printComposerJsonToFilePath($composerJson, $fileInfo->getRealPath());
    }
}
