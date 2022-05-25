<?php

declare (strict_types=1);
namespace EasyCI20220525\Symplify\VendorPatches\Finder;

use EasyCI20220525\Symfony\Component\Finder\Finder;
use EasyCI20220525\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use EasyCI20220525\Symplify\SmartFileSystem\SmartFileInfo;
use EasyCI20220525\Symplify\VendorPatches\Composer\PackageNameResolver;
use EasyCI20220525\Symplify\VendorPatches\ValueObject\OldAndNewFileInfo;
final class OldToNewFilesFinder
{
    /**
     * @var \Symplify\SmartFileSystem\Finder\FinderSanitizer
     */
    private $finderSanitizer;
    /**
     * @var \Symplify\VendorPatches\Composer\PackageNameResolver
     */
    private $packageNameResolver;
    public function __construct(\EasyCI20220525\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer, \EasyCI20220525\Symplify\VendorPatches\Composer\PackageNameResolver $packageNameResolver)
    {
        $this->finderSanitizer = $finderSanitizer;
        $this->packageNameResolver = $packageNameResolver;
    }
    /**
     * @return OldAndNewFileInfo[]
     */
    public function find(string $directory) : array
    {
        $oldAndNewFileInfos = [];
        $oldFileInfos = $this->findSmartFileInfosInDirectory($directory);
        foreach ($oldFileInfos as $oldFileInfo) {
            $oldRealPath = $oldFileInfo->getRealPath();
            $oldStrrPos = (int) \strrpos($oldRealPath, '.old');
            if (\strlen($oldRealPath) - $oldStrrPos !== 4) {
                continue;
            }
            $newFilePath = \substr($oldRealPath, 0, $oldStrrPos);
            if (!\file_exists($newFilePath)) {
                continue;
            }
            $newFileInfo = new \EasyCI20220525\Symplify\SmartFileSystem\SmartFileInfo($newFilePath);
            $packageName = $this->packageNameResolver->resolveFromFileInfo($newFileInfo);
            $oldAndNewFileInfos[] = new \EasyCI20220525\Symplify\VendorPatches\ValueObject\OldAndNewFileInfo($oldFileInfo, $newFileInfo, $packageName);
        }
        return $oldAndNewFileInfos;
    }
    /**
     * @return SmartFileInfo[]
     */
    private function findSmartFileInfosInDirectory(string $directory) : array
    {
        $finder = \EasyCI20220525\Symfony\Component\Finder\Finder::create()->in($directory)->files()->exclude('composer/')->exclude('ocramius/')->name('*.old');
        return $this->finderSanitizer->sanitize($finder);
    }
}
