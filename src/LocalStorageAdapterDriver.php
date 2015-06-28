<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\FilesModule\Adapter\AdapterFilesystem;
use Anomaly\FilesModule\Adapter\StorageAdapterFilesystem;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Anomaly\Streams\Platform\Application\Application;
use League\Flysystem\Adapter\Local;

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
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * The configuration repository.
     *
     * @var ConfigurationRepositoryInterface
     */
    protected $configuration;

    /**
     * Create a new LocalStorageAdapterDriver instance.
     *
     * @param Application                      $application
     * @param ConfigurationRepositoryInterface $configuration
     */
    function __construct(Application $application, ConfigurationRepositoryInterface $configuration)
    {
        $this->application   = $application;
        $this->configuration = $configuration;
    }

    /**
     * Return the configured filesystem driver.
     *
     * @param DiskInterface $disk
     * @return AdapterFilesystem
     */
    public function make(DiskInterface $disk)
    {
        $mode = $this->configuration->get(
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
            new Local($this->application->{$method}("streams/files/{$disk->getSlug()}"))
        );
    }
}
