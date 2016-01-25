# silverstripe-select2

4 silverstripe form fields based on http://ivaynberg.github.com/select2/.

## Requirements

SilverStripe framework 3.0 +

## Maintainer Contact

*  Shea Dawson (<shea@livesource.co.nz>)

## Select2Field

A basic dropdown field with enhanced Select2 UI

## MultiSelect2Field

A multiple select dropdown field with Select2 UI

## GroupedDropdownField

Extends SilverStripes GroupedDropdownField to add the Select2 UI

## AjaxSelect2Field

The AjaxSelect2Field is a dropdown field that makes use of the ajax result loading and infinite scroll features of select2. This is really useful when you need to offer users a way of choosing an object from a list of hundreds or thousands of records that would either break or make standard dropdown/select fields slow and heavy to load. Note that this does not currently work with multiple selection. PR welcome ;)

### Usage

A basic implementation will use configuration defaults to provide a dropdown list of SiteTree objects, suitable for searching for and selecting a page.

```php
$field = AjaxSelect2Field::create('PageID');
``` 

### Configuration

You can configure your instance of AjaxSelect2Field with the following api. The setConfig() method is chainable, too. 

#### Examples

```php
// Set a class to search for. Defaults to SiteTree
$field->setConfig('classToSearch', 'MyCustomObject');

// Set a list of fields to search on. Default is Title 
$field->setConfig('searchFields', array('Title', 'ID'));

// Limit the number of results loaded per page (scroll set). Default is 200
$field->setConfig('resultsLimit', 100);

// The number of characters typed before search results are displayed. Default is 2.
$field->setConfig('minimumInputLength', 3);

// Configure how items should be displayed in the results list. The value gets parsed by the template parser
// You can use HTML too. Default is '$Title'.
$field->setConfig('resultsFormat', '<strong>$Title</strong><br />$AbsuluteLink');

// Configure how the currently selected item should be displayed. Default is '$Title'.
$field->setConfig('selectionFormat', '$Title ($ClassName)');

// Configure the text displayed when no item is selected. Default is 'Search...'
$field->setConfig('placeholder', 'Search for a Page...');

// Allow selection of multiple results. NOTE - you must handle the selected IDs (comma separated list) in code
$field->setConfig('multiple', true);

``` 
