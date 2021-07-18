<?php
/* Smarty version 3.1.39, created on 2021-07-17 19:44:24
  from '/var/www/html/views/index.inc' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60f33318b1a878_02430295',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9f4b3c2c4dfd7ce68de02e651006d6787bd50770' => 
    array (
      0 => '/var/www/html/views/index.inc',
      1 => 1626550551,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60f33318b1a878_02430295 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>test1</th>
                <th>test2</th>
            </tr>
        </thead>
        <tbody>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['people']->value, 'p', false, 'k');
$_smarty_tpl->tpl_vars['p']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->do_else = false;
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['p']->value;?>
</td>
            </tr>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </tbody>
    </table>
</body>
</html>
<?php }
}
