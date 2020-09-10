<?php /* Smarty version 2.5.0, created on 2013-11-14 07:58:06
         compiled from pagination.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'assign', 'pagination.tpl', 2, false),
array('function', 'math', 'pagination.tpl', 9, false),)); ?>
<?php echo $this->_plugins['function']['assign'][0](array('var' => 'putDots','value' => 3), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'border','value' => 2), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'firstpage','value' => 1), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'curPage','value' => $this->_tpl_vars['curPage']), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'url','value' => "home.php?page=%x"), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'totalPages','value' => 0), $this) ; ?>


<?php echo $this->_plugins['function']['math'][0](array('assign' => 'totalPages','equation' => "totalrecords/limit",'totalrecords' => $this->_tpl_vars['totalrecord'],'limit' => $this->_tpl_vars['limit']), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'previous','value' => 0), $this) ; ?>

<?php echo $this->_plugins['function']['assign'][0](array('var' => 'nextpage','value' => 0), $this) ; ?>

<?php echo $this->_plugins['function']['math'][0](array('assign' => 'previous','equation' => "curPage-1",'curPage' => $this->_tpl_vars['curPage']), $this) ; ?>

<?php echo $this->_plugins['function']['math'][0](array('assign' => 'nextpage','equation' => "curPage+1",'curPage' => $this->_tpl_vars['curPage']), $this) ; ?>

<div class="pagination-main">


<?php echo $this->_tpl_vars['paginationdiv']; ?>


</div>





