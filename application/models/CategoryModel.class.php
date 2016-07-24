<?php
//商品分类模型
class CategoryModel extends Model {

    //获取所有的分类
    public function getCategorys() {
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);

        //对获取的分类进行重新排序
        return $this->treeCats($cats);
    }

    //对给定的数组进行重新排序
    public function treeCats($arr, $pid = 0, $level = 0) {
        static $res = array();
        foreach ($arr as $v) {
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level;
                $res[] = $v;
                $this->treeCats($arr, $v['cat_id'], $level+1);
            }
        }
        return $res;
    }

    //指定一个id,获取其后代所有分类的id
    public function subIds($id) {
        $sql = "SELECT * FROM {$this->table}";
        $cats = $this->db->getAll($sql);
        $res = $this->treeCats($cats, $id);

        $subIds = array();
        foreach ($res as $v) {
            $subIds[] = $v['cat_id'];
        }
        //将自己也追加进来
        $subIds[] = $id;
        return $subIds;
    }

}