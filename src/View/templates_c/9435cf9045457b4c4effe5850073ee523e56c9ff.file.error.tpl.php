<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-04-30 07:28:16
         compiled from "/Users/thanh/Library/Mobile Documents/com~apple~CloudDocs/programming/Cleanify/src/View/templates/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4306375925541b7ab1c54a4-18998148%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9435cf9045457b4c4effe5850073ee523e56c9ff' => 
    array (
      0 => '/Users/thanh/Library/Mobile Documents/com~apple~CloudDocs/programming/Cleanify/src/View/templates/error.tpl',
      1 => 1430371694,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4306375925541b7ab1c54a4-18998148',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5541b7ab2fab42_53202514',
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5541b7ab2fab42_53202514')) {function content_5541b7ab2fab42_53202514($_smarty_tpl) {?><html>
<head>
    <title>Cleanfiy Challenge</title>
</head>
<body>
Sorry! There was an issue with your entry:
<br><br>

<p style="color:red;"><?php echo $_smarty_tpl->tpl_vars['data']->value;?>
</p>

<br>

:(

<br><br>
Please resubmit again.

<a href="index.php">let me do it again!</a>
</body>
</html><?php }} ?>
