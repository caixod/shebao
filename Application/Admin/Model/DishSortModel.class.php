<?php
namespace Admin\Model;
use Think\Model;
class DishSortModel extends Model {
    protected $patchValidate = true; // 系统支持数据的批量验证功能，
    protected $_validate = array(
        array('dish_name','require','分类名称必须填写！',1 ,'',3),
    );


}