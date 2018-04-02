<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model {
    protected $patchValidate = true; // 系统支持数据的批量验证功能，
    protected $_validate = array(
        array('name','require','菜品名称必须填写！',1 ,'',3)
    );


}