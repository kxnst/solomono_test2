<?php


class Model_api extends Model
{
    public function getItems(){
            switch (strtolower($_GET['order'])) {
                case ("name" || "date" || "price"):
                    $queryParams = " ORDER BY " . $_GET['order'];
                    break;
                default:
                    $queryParams = " ORDER BY `name`";
                    break;
            };
            if($_GET['order']=="date")
                $queryParams.=" DESC";
            if(isset($_GET['category'])||$_GET['category'])
                $queryParams = "WHERE `category` = ".$_GET['category'].$queryParams;
            $query =  DBConnection::getInstance()->getConnection()->query("SELECT * FROM `site_items`".$queryParams);
            $array = [];
            while ($tmp = ($query->fetch_object("Item")))
                $array[]=$tmp;
            return $array;
        }
        public function getItem(){
            $id = $_GET['id'];
            $result = DBConnection::getInstance()->getConnection()->query("SELECT * FROM `site_items` JOIN (SELECT id as cat_id, name as cat_name FROM `site_categories`) as cats on cats.cat_id = site_items.category WHERE site_items.id = $id");
            return $result->fetch_object();
        }
}