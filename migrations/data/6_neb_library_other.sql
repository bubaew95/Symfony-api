INSERT INTO `user` (`id`, `email`, `roles`, `password`, `phone`, `work_or_school`, `is_admin`, `actived`, `ip`, `user_agent`, `home_address`, `is_subscribe`, `last_sur_name`, `status`, `date`, `hash`, `first_name`, `middle_name`, `last_name`) VALUES
(4141,	'test-2@kertzmann.org',	'[\"ROLE_ADMIN\"]',	'$2y$13$PRQd7CAZ4I5QZ.pj2FdnpORatOsvl9mx4lGLsWyDtDJv4yMWAEAcm',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2004-09-28 18:09:12',	NULL,	'Porro quia inventore dolorem velit sunt.',	'Magni dolorem fugiat blanditiis dolor.',	'Non vel velit fugiat inventore harum.');

INSERT INTO `api_token` (`id`, `user_by_id`, `expires_at`, `token`, `scopes`) VALUES
(1,	1,	NULL,	'tcp_d420c809e6bd898890ca07e7296839cccaccb16923ea0babf6e75658f57ec7e2',	'[\"ROLE_BOOK_CREATE\",\"ROLE_USER_EDIT\"]'),
(2,	4141,	NULL,	'tcp_15dae7bd26923103d137f9ba53b5868cc67a936cf8118b46da9fc2df05a28d0c',	'[\"ROLE_BOOK_CREATE\",\"ROLE_USER_EDIT\"]');
