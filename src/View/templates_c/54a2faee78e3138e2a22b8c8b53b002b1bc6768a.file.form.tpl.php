<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-04-28 01:42:51
         compiled from "../View/templates/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1239263591553eb19a2ec2e6-65176180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54a2faee78e3138e2a22b8c8b53b002b1bc6768a' => 
    array (
      0 => '../View/templates/form.tpl',
      1 => 1430178151,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1239263591553eb19a2ec2e6-65176180',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_553eb19a34d9d5_00193962',
  'variables' => 
  array (
    'formData' => 0,
    'formField' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_553eb19a34d9d5_00193962')) {function content_553eb19a34d9d5_00193962($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/Users/thanh/Library/Mobile Documents/com~apple~CloudDocs/programming/Cleanify/src/Helper/Smarty-3.1.21/libs/plugins/function.cycle.php';
?>form

<table>
    <form action="" method="post" name="cleanifyForm">
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
"></td></tr>
    <?php } ?>
    </form>
</table>
<?php }} ?>
