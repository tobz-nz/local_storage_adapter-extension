<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\FilesModule\Adapter\AdapterFilesystem;
use Anomaly\FilesModule\Disk\Contract\DiskInterface;
use League\Flysystem\MountManager;

/**
 * Class LocalStorageAdapterMounter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterMounter
{

    /**
     * The mount manager.
     *
     * @var MountManager
     */
    protected $manager;

    /**
     * Create a new LocalStorageAdapterMounter instance.
     *
     * @param MountManager $manager
     */
    public function __construct(MountManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Mount the disk.
     *
     * @param DiskInterface     $disk
     * @param AdapterFilesystem $driver
     */
    public function mount(DiskInterface $disk, AdapterFilesystem $driver)
    {
        $this->manager->mountFilesystem($disk->getSlug(), $driver);
    }
}
