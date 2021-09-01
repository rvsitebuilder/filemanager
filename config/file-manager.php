<?php

use Alexusmai\LaravelFileManager\Services\ACLService\ConfigACLRepository;
use Alexusmai\LaravelFileManager\Services\ConfigService\DefaultConfigRepository;

return [
    'name' => 'rvsitebuilder/filemanager',
    /*
     * list of disk names that you want to use
     * (from config/filesystems)
     */
    'diskList' => ['apps', 'apps_public'],

    /*
     * Default disk for left manager
     * null - auto select the first disk in the disk list
     */
    'leftDisk' => null,

    /*
     * Default disk for right manager
     * null - auto select the first disk in the disk list
     */
    'rightDisk' => null,

    /*
     * Image cache ( Intervention Image Cache )
     * set null, 0 - if you don't need cache (default)
     * if you want use cache - set the number of minutes for which the value should be cached
     */
    'cache' => null,

    /*
     * File manager modules configuration
     * 1 - only one file manager window
     * 2 - one file manager window with directories tree module
     * 3 - two file manager windows
     */
    'windowsConfig' => 2,
    /*
     * File upload - Max file size in KB
     *
     * null - no restrictions
     */
    'maxUploadFileSize' => null,
    /*
     * File upload - Allow these file types
     *
     * [] - no restrictions
     */
    'allowFileTypes' => [],
    // Show / Hide system files and folders
    // default true
    'hiddenFiles' => true,

    /***************************************************************************
     * Middleware
     * Add your middleware name to array -> ['web', 'auth', 'admin']
     * !!!! RESTRICT ACCESS FOR NON ADMIN USERS !!!!
     *
     * !!! For using ACL - add 'fm-acl' to array !!! ['web', 'fm-acl']
     */
    'middleware' => ['web', 'admin', 'fm-acl'],

    /***************************************************************************
     * ACL mechanism ON/OFF
     *
     * default - false(OFF)
     */
    'acl' => true,

    /*
     * Hide files and folders from file-manager if user doesn't have access
     * ACL access level = 0
     */
    'aclHideFromFM' => true,

    /*
     * ACL strategy
     *
     * blacklist - Allow everything(access - 2 - r/w) that is not forbidden by the ACL rules list
     *
     * whitelist - Deny anything(access - 0 - deny), that not allowed by the ACL rules list
     */
    'aclStrategy' => 'blacklist',

    /*
     * Set Config repository
     *
     * Default - DefaultConfigRepository get config from this file
     */
    'configRepository' => DefaultConfigRepository::class,

    /*
     * ACL rules repository
     *
     * Default - ConfigACLRepository (see rules in - aclRules)
     */
    'aclRepository' => ConfigACLRepository::class,

    /*
     * ACL rules list - used for default repository
     *
     * 1 it's user ID
     * null - for not authenticated user
     *
     * 'disk' => 'disk-name'
     *
     * 'path' => 'folder-name'
     * 'path' => 'folder1*' - select folder1, folder12, folder1/sub-folder, ...
     * 'path' => 'folder2/*' - select folder2/sub-folder,... but not select folder2 !!!
     * 'path' => 'folder-name/file-name.jpg'
     * 'path' => 'folder-name/*.jpg'
     *
     * * - wildcard
     *
     * access: 0 - deny, 1 - read, 2 - read/write
     */
    'aclRules' => [
        null => [
            //['disk' => 'public', 'path' => '/', 'access' => 2],
        ],
        1 => [
            //all vender/packages/node_modules access: 0 - deny
            [
                'disk' => 'apps',
                'path' => '*/*/node_modules',
                'access' => 0,
            ],
            //under folder vendor rvsitebuilder/* access: 1 read
            [
                'disk' => 'apps',
                'path' => 'rvsitebuilder/*',
                'access' => 1,
            ],

        ],
    ],

    /*
     * ACL Rules cache
     *
     * null or value in minutes
     */
    'aclRulesCache'
=> null,
];
