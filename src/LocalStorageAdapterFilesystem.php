<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Anomaly\FilesModule\Support\Filesystem;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Filesystem\FilesystemManager;
use League\Flysystem\Adapter\Local;

/**
 * Class LocalStorageAdapterFilesystem
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterFilesystem
{

    /**
     * Handle loading the filesystem.
     *
     * @param DiskInterface     $disk
     * @param FilesystemManager $manager
     * @param Application       $application
     */
    public function load(DiskInterface $disk, FilesystemManager $manager, Application $application)
    {
        $manager->extend(
            $disk->getSlug(),
            function () use ($disk, $application) {
                return new Filesystem($disk, new Local($application->getStoragePath("files/{$disk->getSlug()}")));
            }
        );
    }
}
