<?php
$CONFIG = array (
  'htaccess.RewriteBase' => '/',
  'memcache.local' => '\\OC\\Memcache\\APCu',
  'apps_paths' => 
  array (
    0 => 
    array (
      'path' => '/var/www/html/apps',
      'url' => '/apps',
      'writable' => false,
    ),
    1 => 
    array (
      'path' => '/var/www/html/custom_apps',
      'url' => '/custom_apps',
      'writable' => true,
    ),
  ),
  'upgrade.disable-web' => true,
  'passwordsalt' => 'wAmojwwsUfUXGesj/NAjE35DR3lKn9',
  'secret' => 'oqQYpJ0YxjCYxEALROpxN9q4p1SiHsEuU2qLPvpX1zILXPFm',
  'trusted_domains' => 
  array (
    0 => '192.168.1.25',
    1 => 'intranet.emanciper.org',
  ),
  'datadirectory' => '/var/www/html/data',
  'dbtype' => 'pgsql',
  'version' => '30.0.5.1',
  'overwrite.cli.url' => 'https://intranet.emanciper.org:443',
  'dbname' => 'nextcloud',
  'dbhost' => 'postgres',
  'dbport' => '',
  'dbtableprefix' => 'oc_',
  'dbuser' => 'oc_dieu',
  'dbpassword' => 'KcS5Nw9fUtH6OYfzWDRgygdLpg6jUt',
  'installed' => true,
  'instanceid' => 'oc52j0y493cl',
  'ldapProviderFactory' => 'OCA\\User_LDAP\\LDAPProviderFactory',
  'app_install_overwrite' => 
  array (
    0 => 'talk_simple_poll',
    1 => 'talked',
    2 => 'mindmap_app',
    3 => 'files_markdown',
  ),
  'trusted_proxies' => 
  array (
    0 => '177.129.46.124',
    1 => '2a02:842b:6c02:5501:b2b3:69ff:fee5:682e',
    2 => '192.168.1.25',
  ),
  'overwritehost' => 'intranet.emanciper.org:443',
  'overwriteprotocol' => 'https',
  'overwritewebroot' => '/',
  'overwritecondaddr' => '^177\\.129\\.46\\.124$',
  'default_language' => 'fr',
  'default_locale' => 'fr_FR',
  'default_phone_region' => 'fr',
  'loglevel' => '2',
  'log_type' => 'file',
  'logfile' => 'nextcloud.log',
  'mail_from_address' => 'webmaster',
  'mail_smtpmode' => 'smtp',
  'mail_sendmailmode' => 'smtp',
  'mail_domain' => 'emanciper.org',
  'mail_smtphost' => 'smtp.mail.ovh.net',
  'mail_smtpport' => '465',
  'mail_smtpauth' => 1,
  'mail_smtpname' => 'webmaster@emanciper.org',
  'mail_smtppassword' => 'xxxx',
  'maintenance' => false,
);
