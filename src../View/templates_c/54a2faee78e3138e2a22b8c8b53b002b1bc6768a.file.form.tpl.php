<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-04-29 06:29:05
         compiled from "/Users/thanh/Library/Mobile Documents/com~apple~CloudDocs/programming/Cleanify/src/View/templates/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:631993197553ee0b28d7341-04985574%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54a2faee78e3138e2a22b8c8b53b002b1bc6768a' => 
    array (
      0 => '/Users/thanh/Library/Mobile Documents/com~apple~CloudDocs/programming/Cleanify/src/View/templates/form.tpl',
      1 => 1430281742,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '631993197553ee0b28d7341-04985574',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_553ee0b2a03352_68410570',
  'variables' => 
  array (
    'formUrl' => 0,
    'formData' => 0,
    'formField' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_553ee0b2a03352_68410570')) {function content_553ee0b2a03352_68410570($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/Users/thanh/Library/Mobile Documents/com~apple~CloudDocs/programming/Cleanify/src/Helper/Smarty-3.1.21/libs/plugins/function.cycle.php';
?><html>
<head>
    <title>Cleanify Dynamic Form</title>
</head>
<body>
    <table>
        <form action="<?php echo $_smarty_tpl->tpl_vars['formUrl']->value;?>
" method="post" name="cleanifyForm">
            <?php  $_smarty_tpl->tpl_vars['formField'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['formField']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['formData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['formField']->key => $_smarty_tpl->tpl_vars['formField']->value) {
$_smarty_tpl->tpl_vars['formField']->_loop = true;
?>
                <tr bgcolor="<?php echo smarty_function_cycle(array('values'=>"#eeeeee,#dddddd"),$_smarty_tpl);?>
"><td><?php echo $_smarty_tpl->tpl_vars['formField']->value['field_value'];?>
</td><td><input type="<?php echo $_smarty_tpl->tpl_vars['formField']->value['input_type'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['formField']->value['field_name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['formField']->value['field_name'];?>
 value="<?php echo $_smarty_tpl->tpl_vars['formField']->value['form_value'];?>
"></td></tr>
            <?php } ?>
            <tr>
                <td align="right">
                    <input type="reset" value="reset">
                </td>
                <td>
                    <input type="submit" value="submit">
                </td>
            </tr>

        </form>
    </table>
</body>
</html>

<?php }} ?>
