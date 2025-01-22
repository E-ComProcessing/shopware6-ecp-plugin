<?php return array(
    'root' => array(
        'name' => 'ecomprocessing/genesis',
        'pretty_version' => '1.4.0',
        'version' => '1.4.0.0',
        'reference' => NULL,
        'type' => 'shopware-platform-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => false,
    ),
    'versions' => array(
        'ecomprocessing/genesis' => array(
            'pretty_version' => '1.4.0',
            'version' => '1.4.0.0',
            'reference' => NULL,
            'type' => 'shopware-platform-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'genesisgateway/genesis_php' => array(
            'pretty_version' => '2.0.2',
            'version' => '2.0.2.0',
            'reference' => 'b0dcf2f18de2d2f090b68146a5719827460ad5c5',
            'type' => 'library',
            'install_path' => __DIR__ . '/../genesisgateway/genesis_php',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
