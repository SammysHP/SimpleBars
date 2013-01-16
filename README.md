SimpleBars
==========

Creates simple bar graphs with HTML and CSS.

![Example](http://www.sammyshp.de/misc/simplebars_example.jpg)

There are many tools that generate images (png, gif, ...) or require JavaScript. This class generates a bar graph with pure HTML and CSS.


Usage
-----

```php
<?php
require_once("SimpleBars.php");

$graph = new SimpleBars();
$graph
    ->setTitle("Example")
    ->setData(array(14, 6, 26));
echo $graph->render();
```

For more examples and help see ```example.php``` and inline documentation.


Credits
-------

Sven Karsten Greiner

http://www.sammyshp.de/


License
-------

GNU General Public License, version 3 or later

See http://www.gnu.org/licenses/
