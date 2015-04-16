<?php namespace Anomaly\LocalStorageAdapterExtension;

use Anomaly\FilesModule\Adapter\StorageAdapterExtension;

/**
 * Class LocalStorageAdapterExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\LocalStorageAdapterExtension
 */
class LocalStorageAdapterExtension extends StorageAdapterExtension
{

    /**
     * This module provides the local
     * storage adapter for the files module.
     *
     * @var string
     */
    protected $provides = 'anomaly.module.files::storage_adapter.local';

}
