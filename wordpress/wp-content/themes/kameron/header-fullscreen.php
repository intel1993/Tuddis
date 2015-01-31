<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<!-- The quickest way for us to know that JavaScript is turned on -->
<script type="text/javascript">document.documentElement.className = 'js';</script>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<?php
// PHPish whitespace doesn't get rendered






















