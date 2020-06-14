# Wordpress Simple User Plugin

Create Wordpress users simply by their names

## Dev Guide

In order to hack on this plugin in a very easy way, use the incluced [docker-compose](https://docs.docker.com/compose/) config, i.e. just run the following from the root folder:

```bash
$ docker-compose up -d
```

Once all the services are up, visit [http://localhost:8080](http://localhost:8080). The first time, you must go through the Wordpress installation process. Use the following links to quickly access relevant areas during development:

* [Admin Area](http://localhost:8080/wp-admin)
* [Installed Plugins](http://localhost:8080/wp-admin/plugins.php)

Other handy *docker-compose* commands are `stop` and `start` (or `restart`). Please not that running the `down` command will remove also volumes which means that you will have to start from scratch on a subsequent `up` execution.
