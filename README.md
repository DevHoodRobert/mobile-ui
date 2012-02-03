# Mobile UI Application Framework

## What is the mobile-ui?

The mobile-ui is a PHP library that creates complete mobile applications
based on PHP, a custom XML format and jQuery UI mobile.

You call XML files in your browser, they run through a PHP framework,
eventually get parsed and cached and will be shown as valid HTML5

The XML tags in your XML file will be parsed into mobile controls
that represent classes in the framework (See the DevHood\Mobile\Controls namespace)

A basic mobile page would look like this
**home.xml:**

```xml
<?xml version="1.0" encoding="utf-8"?>
<page id="home">
	<top>
		<button type="back">Back</button>
		<title>My mobile page</title>
		<button to="login">Login</button>
	</top>
	<content>
		
		<!-- the controls that should be shown -->
		
	</content>
</page>
```

## How do the controls work?

The controls react to two handlers, `handleTagStart` and `handleTagEnd`.

Containers usually need to use both while single tags usually only utilize
`handleTagEnd`

A basic control class looks like this:

```php
<?php

namespace DevHood\Mobile\Controls;

class MyControl extends \DevHood\Mobile\Control {

	public function handleTagStart() {
		
		?><div class="my-control-div"><?php
	}
	
	public function handleTagEnd() {
		
		?></div><?php
	}
}
```

The XML tag <myControl> would trigger this class

Upon encountering the tag-start, the arguments will be put into the class 
(See DevHood\Type->_args) and the start tag handler will be called

When the tag is closed, the end tag handler will be called

If there is content between the tags, there property _cdata will be filled with it.

You may access this character data with the method `$this->getCdata()`

**Warning: Character data is only available in handleTagEnd, not in handleTagStart**

## Referencing parent controls

Some controls might need to know which kind of parent control they have

This is easily done with PHP's `instanceof` instruction

A good example for this is the Title-control at
https://github.com/DevHood/mobile-ui/blob/master/library/DevHood/Mobile/Controls/Title.php

Currently the title element only does something, if the parent control is a
`Top` control. It will also set a new argument for the top control to indicate that
it already got a title now. From there on, buttons will check the argument and
put themself on the right side if needed

Manually added attributes should be prefixed with an ampersand (&), since these can't
be set in the XML (& will lead to a parse error in the XML)

## Working with databases

The mobile-ui implements a basic but working database abstraction layer
that can be used together with the Data and DataSource controls (maybe more later)

DataSource can define a data source in the global app registry
Data is able to work with that DataSource and retrieves data that is
stored in the global app registry

Controls can now utilize this Data if they can access the key of the
global app registry
An example of this would be the List-control, that can either have
manually defined items and dividers or just reference data-entries that are
fetched with a Data control before
With attribute-based templates and markdown you can easily create full controls
without using any SQL, HTML, CSS, JavaScript or PHP.

## Notes and credits

This library is very uncomplete yet.

It works and is quite stable, but there is still much to do

If you want to contribute, feel free to contact us via GitHub or mail.

Github URL:
https://github.com/DevHood/mobile-ui

E-Mail:
devhood@live.com


Credits go to:

- jQuery (http://jquery.com) for the greatest javascript library there is
- DevHoodRobert (https://github.com/DevHoodRobert) for support
- zorndyuke (https://github.com/zorndyuke) for support
- Nescafe for keeping us awake and motivated