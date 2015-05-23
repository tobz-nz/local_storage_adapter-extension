<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\FilesModule\Adapter\StorageAdapterFilesystem;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
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
     * @param DiskInterface                    $disk
     * @param FilesystemManager                $manager
     * @param Application                      $application
     * @param ConfigurationRepositoryInterface $configuration
     */
    public function load(
        DiskInterface $disk,
        FilesystemManager $manager,
        Application $application,
        ConfigurationRepositoryInterface $configuration
    ) {
        $manager->extend(
            $disk->getSlug(),
            function () use ($disk, $application, $configuration) {

                $mode = $configuration->get(
                    'anomaly.extension.local_storage_adapter::privacy',
                    $disk->getSlug(),
                    'public'
                );

                if ($mode === 'private') {
                    $method = 'getStoragePath';
                } else {
                    $method = 'getAssetsPath';
                }

                return new StorageAdapterFilesystem(
                    $disk,
                    new Local(
                        $application->{$method}("streams/files/{$disk->getSlug()}")
                    )
                );
            }
        );
    }
}
