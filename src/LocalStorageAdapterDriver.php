<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\FilesModule\Adapter\AdapterFilesystem;
use Anomaly\FilesModule\Adapter\StorageAdapterFilesystem;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Anomaly\Streams\Platform\Application\Application;
use League\Flysystem\Adapter\Local;
use League\Flysystem\MountManager;

/**
 * Class LocalStorageAdapterDriver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterDriver
{

    /**
     * Return the configured filesystem driver.
     *
     * @param ConfigurationRepositoryInterface $configuration
     * @param DiskInterface                    $disk
     * @param Application                      $application
     * @return AdapterFilesystem
     */
    public function make(ConfigurationRepositoryInterface $configuration, DiskInterface $disk, Application $application)
    {
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

        return new AdapterFilesystem(
            $disk,
            new Local(
                $application->{$method}("streams/files/{$disk->getSlug()}")
            )
        );
    }
}
