<?php
if(!defined("ABSPATH")) exit; // Exit if accessed directly

if(!function_exists("_ctc")) {
  /**
   * A self closing element with the given attributes
   * @param  string  $tag         The HTML tag name, eg "img"
   * @param  Array  $attrs        (optional) A list of attributes, like "class" => "my-class"
   * @param  boolean $echo        (optional) If true, the resulting tag will be echoed, otherwise it is returned. Defaults to true.
   * @param boolean $esc          True if attributes should be escaped, false if escaping has already been done.
   * @return mixed                void if $echo is true, otherwise a string representation of the element.
   *
   * Assumes attr values have already been escaped.
   */
  function _ctc($tag, $attrs = [], $echo = true, $esc = true) {
    $tag = esc_attr($tag);
    $element = "<$tag";
    foreach($attrs as $name => $value) {
      if($esc) $value = esc_attr($value);
      $element .= " ".esc_attr($name)."=\"".$value."\"";
    }
    $element .= "/>";
    if($echo) echo $element;
    else return $element;
  }
}

if(!function_exists("_ct")) {
  /**
   * An open element with the given attributes.
   * @param  string  $tag         (optional) The HTML tag name, eg "img". If no tag is given, the current block will be closed.
   * @param  Array  $attrs        (optional) A list of attributes, like "class" => "my-class"
   * @param  boolean $echo        (optional) If true, the resulting tag will be echoed, otherwise it is returned. Defaults to true.
   * @param boolean $esc          True if attributes should be escaped, false if escaping has already been done.
   * @return mixed                void if $echo is true, otherwise a string representation of the element.
   *
   * Assumes attr values have already been escaped.
   */
  function _ct($tag = false, $attrs = [], $echo = true, $esc = true) {
    // Keeps track of all open html blocks
    static $tagQueue = array();

    if(!$tag && !count($tagQueue)) return; // No element to close, return early

    if($tag) {
      $tagQueue[] = $tag;
      $element = "<".esc_attr($tag);
      foreach($attrs as $name => $value) {
        if($esc) $value = esc_attr($value);
        $element .= " ".esc_attr($name);
        if($value) $element .= "=\"".$value."\"";
      }
    }
    else {
      $element = "</".esc_attr(array_pop($tagQueue));
    }
    $element .= ">";

    if($echo) echo $element;
    else return $element;
  }
}
