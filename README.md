# Canadian Geospatial Platform (CGP)

This project contains a collection of shortcodes used to by the CGP project.
They mainly allow a user to fetch and display geospatial data from an API.

## Getting Started

These instructions will get you a copy of the project up and running on your
local machine for development and testing purposes.

### Prerequisites

- Docker ( <https://docs.docker.com/v17.09/engine/installation/> )

### Installing

In a terminal from the root of the project start docker:

```
sudo docker-compose up
```

Then, visit the following urls to access the project

- website: <http://localhost:8080/>
- website admin page: <http://localhost:8080/wp-admin>
- phpMyAdmin: <http://localhost:3333/>

## Adding content

### shortcodes

1. open wp-content/plugins/cgp-shortcodes/public/class-cgp-shortcodes-public.php
2. copy `hello_world_shortcode()` and rename it to _X_
3. open wp-content/plugins/cgp-shortcodes/includes/class-cgp-shortcodes.php
4. find `private function define_public_hooks()`
5. make a copy of the line that registers `hello_world_shortcode()` and rename
   it to refer to _X_
6. The first argument in the function is the shortcode name you use in the
   wordpress text, the second is the method we created at step 2.
7. add the shortcode in a page and preview the result. It should load with
   functional javascript and styling.

```
[cgp-shortcodes-hello-world]
```

### Client side javascript and jQuery

Client side javascript should be added to
wp-content/plugins/cgp-shortcodes/public/js/cgp-shortcodes-public.js

## Deploying the plugin

1. create a zip file of the _cgp-shortcodes_ plugin.
   (wp-content/plugins/cgp-shortcodes -> cgp-shortcodes.zip)
2. go to the plugins section on wordpress admin panel and press the add new
   plugin button on the top left
3. a box should appear to upload your plugin. choose your zip file and upload
   it as is.
4. activate it, it should load and function like any other plugin

## Reference material

This plugin has been created using a template from https://wppb.me/. The
template is based on the following boilerplate:
https://github.com/devinvinson/WordPress-Plugin-Boilerplate/.
