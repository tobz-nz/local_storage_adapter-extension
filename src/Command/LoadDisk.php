<?php namespace Anomaly\LocalStorageAdapterExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\FilesModule\Disk\Adapter\AdapterFilesystem;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\FilesystemManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\MountManager;

/**
 * Class LoadDisk
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension\Command
 */
class LoadDisk implements SelfHandling
{

    /**
     * The disk instance.
     *
     * @var DiskInterface
     */
    protected $disk;

    /**
     * Create a new LoadDisk instance.
     *
     * @param DiskInterface $disk
     */
    public function __construct(DiskInterface $disk)
    {
        $this->disk = $disk;
    }

    /**
     * Handle the command.
     *
     * @param MountManager                     $flysystem
     * @param Application                      $application
     * @param FilesystemManager                $filesystem
     * @param ConfigurationRepositoryInterface $configuration
     * @return AdapterFilesystem
     */
    public function handle(
        MountManager $flysystem,
        Application $application,
        FilesystemManager $filesystem,
        ConfigurationRepositoryInterface $configuration
    ) {
        $mode = $configuration->get(
            'anomaly.extension.local_storage_adapter::privacy',
            $this->disk->getSlug()
        );

        if ($mode === 'private') {
            $method = 'getStoragePath';
        } else {
            $method = 'getAssetsPath';
        }

        $driver = new AdapterFilesystem(
            $this->disk,
            new Local($application->{$method}("files-module/{$this->disk->getSlug()}"))
        );

        $flysystem->mountFilesystem($this->disk->getSlug(), $driver);

        $filesystem->extend(
            $this->disk->getSlug(),
            function () use ($driver) {
                return $driver;
            }
        );
    }
}
