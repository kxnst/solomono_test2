<?php


class Model_main extends Model
{
    public function getItems(){
        $queryParams = "";
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
        if($_GET['category'])
            $queryParams = "WHERE `category` = ".$_GET['category'].$queryParams;
        return DBConnection::getInstance()->getConnection()->query("SELECT * FROM `site_items`".$queryParams);
    }
    public function getCategories(){
        return DBConnection::getInstance()->getConnection()->query("SELECT site_categories.name as name, site_categories.id as id,
        COUNT(site_items.id) as count FROM `site_items` RIGHT JOIN site_categories on site_categories.id = site_items.category GROUP BY site_categories.id");
    }
    public function fillItems(){
        for($i = 0; $i<20;$i++)
            DBConnection::getInstance()->getConnection()->query("INSERT INTO `site_items`( `name`, `date`, `price`, `category`) 
            VALUES ('Товар ".($i+1)."', CURRENT_TIMESTAMP,".rand(100,10000).",".rand(1,5).")");
    }
    public function fillCategories(){
        for($i = 1;$i<6;$i++)
            DBConnection::getInstance()->getConnection()->query("INSERT INTO `site_categories`(`id`,`name`) VALUES (".(intval($i)).",'Категория $i')");
    }
}