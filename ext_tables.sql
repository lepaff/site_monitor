CREATE TABLE tx_sitemonitor_domain_model_clientgroup (
	title           varchar(255) NOT NULL DEFAULT '',
	clients         int(11) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_sitemonitor_clientgroup_client_mm (
	uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
	sorting         int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_sitemonitor_domain_model_client (
	title           varchar(255) NOT NULL DEFAULT '',
	username        varchar(255) NOT NULL DEFAULT '',
	password        varchar(255) NOT NULL DEFAULT '',
	secret          varchar(255) NOT NULL DEFAULT '',
	type_param      varchar(255) NOT NULL DEFAULT '',
	url             varchar(255) NOT NULL DEFAULT '',
	htaccess        tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ht_user         varchar(255) NOT NULL DEFAULT '',
	ht_pass         varchar(255) NOT NULL DEFAULT '',
	url_fe          varchar(255) NOT NULL DEFAULT '',
	url_be          varchar(255) NOT NULL DEFAULT '',
	url_gitlab      varchar(255) NOT NULL DEFAULT '',
	site            int(11) unsigned DEFAULT '0' NOT NULL,
	slug            varchar(255) DEFAULT '' NOT NULL,
	owner           text       NOT NULL,
	developer       text       NOT NULL,
    sorting         int(11) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_sitemonitor_domain_model_site (
	title               varchar(255) NOT NULL DEFAULT '',
	typo3_version       varchar(255) NOT NULL DEFAULT '',
	typo3_context       varchar(255) NOT NULL DEFAULT '',
	php_version         varchar(255) NOT NULL DEFAULT '',
	patch_available     varchar(255) NOT NULL DEFAULT '',
	tstamp_upated       int(11) unsigned DEFAULT '0' NOT NULL,
	installed_extension text NOT NULL,
	slug                varchar(255) DEFAULT '' NOT NULL,
);

CREATE TABLE tx_sitemonitor_client_site_mm (
	uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
	sorting         int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

CREATE TABLE tx_sitemonitor_domain_model_extension (
	title               varchar(255) NOT NULL DEFAULT '',
	version             varchar(255) NOT NULL DEFAULT '',
	version_installed   varchar(255) NOT NULL DEFAULT '',
	extension_doc       varchar(255) NOT NULL DEFAULT '',
);

CREATE TABLE tx_sitemonitor_domain_model_extensiondoc (
	title               varchar(255) NOT NULL DEFAULT '',
	description         text       NOT NULL,
    repository          varchar(255) NOT NULL DEFAULT '',
    is_sys_ext          tinyint(1) unsigned DEFAULT '0' NOT NULL,
    versions            int(11) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_sitemonitor_domain_model_extensionversion (
	version             varchar(255) NOT NULL DEFAULT '',
);

CREATE TABLE tx_sitemonitor_extensiondoc_extensionversion_mm (
	uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
	sorting         int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
