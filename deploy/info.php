<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'antivirus';
$app['version'] = '2.1.6';
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
// Controllers
/////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-network',
);

$app['core_requires'] = array(
    'app-network-core',
    'clamav >= 0.98',
    '/usr/bin/freshclam',
    '/usr/sbin/clamd',
    '/usr/bin/clamscan'
);

$app['core_file_manifest'] = array(
    'clamd.php'=> array('target' => '/var/clearos/base/daemon/clamd.php'),
    'antivirus'=> array(
        'target' => '/var/clearos/events/upstream_proxy/antivirus',
        'mode' => '0755',
    ),
    'clamav-check.sh'=> array(
        'target' => '/usr/sbin/clamav-check.sh',
        'mode' => '0755',
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
