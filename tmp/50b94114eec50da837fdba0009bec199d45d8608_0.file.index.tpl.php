<?php
/* Smarty version 3.1.39, created on 2021-07-17 19:27:36
  from '/var/www/html/views/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60f32f283ee6d5_03549048',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '50b94114eec50da837fdba0009bec199d45d8608' => 
    array (
      0 => '/var/www/html/views/index.tpl',
      1 => 1626550054,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60f32f283ee6d5_03549048 (Smarty_Internal_Template $_smarty_tpl) {
?>Hello 
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['people']->value, 'p', false, 'k');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?> 
<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
 = <?php echo $_smarty_tpl->tpl_vars['p']->value;?>
 
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
