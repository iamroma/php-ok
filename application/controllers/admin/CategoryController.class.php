<?php
//商品分类控制器
class CategoryController extends CoreController {

    //显示分类信息    
    public function indexAction() {
        //获取所有的分类信息
        $categoryModel = new CategoryModel("category");
        $categorys = $categoryModel->getCategorys();

        // var_dump($cats);
		//载入表单
        include CUR_VIEW_PATH . "cat_list.html";
    }

    //显示添加分类表单
    public function addAction() {
        //获取所有的分类
        $categoryModel = new CategoryModel("category");
        $categorys = $categoryModel->getCategorys();
        include CUR_VIEW_PATH . "cat_add.html";
    }

    //完成商品分类入库动作
    public function insertAction() {
        //1.收集表单数据,以关联数组的形式
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['parent_id'] = $_POST['parent_id'];
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = $_POST['is_show'];
        $data['cat_desc'] = trim($_POST['cat_desc']);

        //2.做相应的验证和处理
        if ($data['cat_name'] == '') {
            $this->jump("index.php?p=admin&c=category&a=add", "分类名称不能为空");
        }

        //3.调用模型完成入库并给出提示
        $categoryModel = new CategoryModel("category");
        if ($categoryModel->insert($data)) {
            $this->jump("index.php?p=admin&c=category&a=index", "添加分类成功", 2);
        } else {
            $this->jump("index.php?p=admin&c=category&a=add", "添加分类失败");
        }

    }

    //显示修改分类表单
    public function editAction() {

        //获取cat_id
        $cat_id = $_GET['cat_id'] + 0;
        //得到当前这条记录
        $categoryModel = new CategoryModel("category");
        $cat = $categoryModel->selectByPk($cat_id);
        //获取所有的分类信息
        $cats = $categoryModel->getCategorys();

        include CUR_VIEW_PATH . "cat_edit.html";
    }

    //更新操作
    public function updateAction() {

        //1.收集表单数据
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['parent_id'] = $_POST['parent_id'];
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = $_POST['is_show'];
        $data['cat_desc'] = trim($_POST['cat_desc']);
        $data['cat_id'] = trim($_POST['cat_id']);

        //2.验证及处理
        if ($data['cat_name'] == '') {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}", "分类名称不能为空", 2);
        }

        //不能将当前分类的后代或者自己作为其上级分类
        $categoryModel = new CategoryModel("category");
        $subIds = $categoryModel->subIds($data['cat_id']);
        if (in_array($data['parent_id'], $subIds)) {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}", "上级分类不能选择自己或子类！", 2);
        }

        //3.调用模型完成更新并给出提示
        if ($categoryModel->update($data)) {
            $this->jump("index.php?p=admin&c=category&a=index", "恭喜，分类更新成功！", 2);
        } else {
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id={$data['cat_id']}", "更新分类失败");
        }

    }

    //删除分类
    public function deleteAction() {
        //1.获取cat_id
        $cat_id = $_GET['cat_id'] + 0;

        //2.判断
        $categoryModel = new CategoryModel("category");
        $subIds = $categoryModel->subIds($cat_id);
        if (count($subIds) > 1) {
            $this->jump("index.php?p=admin&c=category&a=index", "不能直接删除有子分类的上级分类", 1);
        }

        //3.调用模型完成删除并给出提示
        if ($categoryModel->delete($cat_id)) {
            $this->jump("index.php?p=admin&c=category&a=index", "恭喜，删除分类成功", 1);
        } else {
            $this->jumo("index.php?p=admin&c=category&a=index", "删除分类失败", 1);
        }
    }
}