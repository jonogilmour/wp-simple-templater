# Simple Wordpress Template Functions
Very simple little tool for programmatically writing markup in PHP functions or templates (suited for Wordpress).

## Rationale

Got sick of mixing PHP and HTML code, especially in simple functions that don't use separate template files. Also makes everything safer by automatically escaping HTML attributes using Wordpress.

## Usage

Comes with two functions, `_ct()`, used for open/close tags, and `_ctc()`, used for self-closing tags.

Open/close tags: `_ct(element, attrs, shouldReturn, autoEscape)`

Self-closing tag: `_ctc(element, attrs, shouldReturn, autoEscape)`

#### Simple Element

```php
<?php
_ct('div');
  echo 'Hello World';
_ct();
?>
```
produces
```html
<div>
  Hello World
</div>
```

#### Adding attributes

```php
<?php
_ct('div', array('id' => 'example', 'class' => 'col-12 main-wrapper'));
  echo 'Hello World';
_ct();
?>
```
produces
```html
<div id="example" class="col-12 main-wrapper">
  Hello World
</div>
```
Note that this integrates with Wordpress `esc_attr()`` automatically, so all attribute values are automatically escaped.

#### Return markup as a string

Pass `false` as the third argument to `return` instead of `echo`ing automatically.

Note to close the tag you'll need to fill in the first two arguments with defaults.

```php
<?php
$html  = _ct('div', array('class' => 'example'), false);  // '<div class="example">'
$html .= 'Hello World';                                   // 'Hello World'
$html .= _ct(false, array(), false);                      // '</div>'
?>
```

#### Manually escaping attributes

The fourth argument is a boolean that turns on/off the automatic escaping of attributes, useful for when you want to not escape certain attribute values, or use a different escaping function. Note that you'll need to manually escape every attribute with this turned off.
```php
<?php
$attrs = array(
  'href' => esc_url('/page1'),
  'id' => esc_attr('example'),
  'onclick' => esc_js('alert(\'Clicked!\');'),
);

_ct('a', $attrs, true, false);
  echo 'Hello World';
_ct();
?>
```
produces:
```html
<a href="/page1" id="example" onclick="alert('Clicked!');">
  Hello World
</a>
```

#### Self-closing tags

For tags like `img`, use `_ctc()`:
```php
<?php
_ctc('img', array('src' => esc_url('http://mysite.com/images/img.jpg'), true, false));
?>
```
prints:
```html
<img src="http://mysite.com/images/img.jpg"/>
```

#### Nesting

The `_ct()` function uses a static queue variable to keep track of open/close tags, so feel free to nest at any level.

```php
<?php
$linkAttrs = array(
  'href' => home_url('/getstarted'),
  'id' => esc_attr('get-started-link'),
);

$imgAttrs = array(
  'src' => esc_url('http://example.com/images/get_started.jpg'),
  'alt' => esc_attr('Get started image'),
)

_ct('a', $linkAttrs, true, false);

  _ct('span', array('class' => 'text-bold'));
    echo esc_html('Click the image below to get started');
  _ct();

  _ctc('img', $imgAttrs, true, false));

_ct();
?>
```

```html
<a href="https://example.com/getstarted" id="get-started-link">
  <span class="text-bold">
    Click the image below to get started
  </span>
  <img src="http://example.com/images/get_started.jpg" alt="Get started image"/>
</a>
```
