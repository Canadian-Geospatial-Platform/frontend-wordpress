# Canadian Geospatial Platform (CGP)

This project contains a collection of shortcodes used to by the CGP project. They mainly allow a user to fetch and display geospatial data from an API.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

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

## Adding a shortcode

1. open wp-content/plugins/cgp-shortcodes/public/class-cgp-shortcodes-public.php
2. copy `hello_world_shortcode()` and rename it to _X_
3. open wp-content/plugins/cgp-shortcodes/includes/class-cgp-shortcodes.php
4. find `private function define_public_hooks()`
5. make a copy of the line that registers `hello_world_shortcode()` and rename it to refer to _X_
6. The first argument in the function is the shortcode name you use in the wordpress text, the second is the method we created at step 2.
7. add the shortcode in a page and preview the result. It should load with functional javascript and styling.

```
[cgp-shortcodes-hello-world]
```
