<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'antivirus';
$app['version'] = '2.4.1';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('antivirus_app_description');
$app['tooltip'] = lang('antivirus_app_tooltip');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('antivirus_app_name');
$app['category'] = lang('base_category_gateway');
$app['subcategory'] = lang('base_subcategory_antimalware');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-network',
);

// syswatch drives the network-connected event
$app['core_requires'] = array(
    'app-events-core',
    'app-network-core >= 1:2.3.28',
    'app-tasks-core',
    'syswatch',
    'clamav >= 0.99.2',
    '/usr/bin/freshclam',
    '/usr/sbin/clamd',
    '/usr/bin/clamscan'
);

// KLUDGE: we are using the network_configuration event for now since
// upstream proxy settings are only configurable through editing a
// WAN interface.

$app['core_file_manifest'] = array(
    'clamd.php'=> array('target' => '/var/clearos/base/daemon/clamd.php'),
    'app-antivirus.cron' => array( 'target' => '/etc/cron.d/app-antivirus'),
    'antivirus'=> array(
        'target' => '/var/clearos/events/network_configuration/antivirus',
        'mode' => '0755',
    ),
    'clamav-check.sh'=> array(
        'target' => '/usr/sbin/clamav-check.sh',
        'mode' => '0755',
    ),
    'freshclam-update'=> array(
        'target' => '/usr/sbin/freshclam-update',
        'mode' => '0755',
    ),
    'network-connected-event'=> array(
        'target' => '/var/clearos/events/network_connected/antivirus',
        'mode' => '0755'
    ),
);

$app['delete_dependency'] = array(
    'app-antivirus-core',
    'app-antimalware-updates',
    'app-antimalware-updates-core',
    'app-antiphishing',
    'app-antiphishing-core',
    'app-content-filter',
    'app-content-filter-core',
    'clamav'
);
