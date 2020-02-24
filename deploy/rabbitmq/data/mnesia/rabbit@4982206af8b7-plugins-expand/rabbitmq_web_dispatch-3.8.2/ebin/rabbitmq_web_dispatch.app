{application, 'rabbitmq_web_dispatch', [
	{description, "RabbitMQ Web Dispatcher"},
	{vsn, "3.8.2"},
	{id, "v3.8.2-rc.1-2-ga40e67c"},
	{modules, ['rabbit_cowboy_middleware','rabbit_cowboy_redirect','rabbit_cowboy_stream_h','rabbit_web_dispatch','rabbit_web_dispatch_app','rabbit_web_dispatch_listing_handler','rabbit_web_dispatch_registry','rabbit_web_dispatch_sup','rabbit_web_dispatch_util','webmachine_log','webmachine_log_handler']},
	{registered, [rabbitmq_web_dispatch_sup]},
	{applications, [kernel,stdlib,inets,rabbit_common,rabbit,cowboy]},
	{mod, {rabbit_web_dispatch_app, []}},
	{env, []},
		{broker_version_requirements, []}
]}.