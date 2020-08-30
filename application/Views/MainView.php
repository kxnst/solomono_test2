<!DOCTYPE html>
<html>
<head>
    <title>Страница ассортимента</title>
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
<div id="header">Тестовое задание 1</div>
<div id="container">
    <div id="categories">
        <select id = "order_select">
            <option value="name">за алфавитом</option>
            <option value="date">сначала новые</option>
            <option value="price">сначала дешевле</option>
        </select>
        <?
        $resource = $data->getCategories();
            while($tmp = ($resource->fetch_object("Category"))) {

                ?>
                <a class = "category_href" href="<?= $tmp->id ?>"><?= $tmp->name . " ($tmp->count)" ?></a>
                <?
            }
        ?>
    </div>
    <div id="items">
        <?
            $items = $data->getItems();
            while($tmp = ($items->fetch_object("Item"))){
                ?>
                <div class="item">
                    <span><?=$tmp->name?></span>
                    <span>Стоимость: <?=$tmp->price?></span>
                    <span>Дата:<?=$tmp->date?></span>
                    <button onclick="buy(<?=$tmp->id?>)">Купить</button>
                </div>
                <?
            }
        ?>
    </div>
</div>
<div id="modal_bg">
    <div id="modal">

    </div>
</div>
<script>
    $(document).ready(function () {
        let url = new URL(window.location.href);
        let order = url.searchParams.get("order");
        if(order){
            $('#order_select').find("option[value ="+order+" ]").attr("selected","selected");
       }
    })
    $(".category_href").click(function (e) {
        e.preventDefault();
        let url = new URL(window.location.href);
        url.searchParams.set("category",$(this).attr('href'));
        window.history.pushState(null,null,url);
        updateItems();
    })
    $('#categories').change(function () {
        let url = new URL(window.location.href);
        url.searchParams.set("order",$(this).find("option:selected").val());
        window.history.pushState(null,null,url);
        updateItems();
    })
    function updateItems() {
        let regex = new RegExp("(^[a-zA-Z0-9\:\/\.])*[?]([a-zA-Z0-9\=\&])*");
        let url = regex.exec(window.location.href);
        $.ajax({
            url:"/api"+url[0],
            complete:function(data){
                let items = JSON.parse(data.responseText);
                $("#items").empty();
                items.forEach(function(item){
                    $("#items").append("<div class=\"item\">\n" +
                        "                    <span>"+item.name+"</span>\n" +
                        "                    <span>Стоимость: "+item.price+"</span>\n" +
                        "                    <span>Дата:"+item.date+"</span>\n" +
                        "<button onclick='buy("+item.id+")'>Купить</button> "+
                        "                </div>")
                })
            }
        });
    }
    function buy(id){
        $.ajax({
            url:"/api/getItem?id="+id,
            success:function (data) {
                let item = JSON.parse(data);
                $("#modal").empty();
                $("#modal").append("<span>Название: "+item.name+"</span>");
                $("#modal").append("<span>Дата: "+item.date+"</span>");
                $("#modal").append("<span>Стоимость: "+item.price+"</span>");
                $("#modal").append("<span>Категория: "+item.cat_name+"</span>");
                $("#modal").append("<button id = 'close_modal'>Закрыть</button>");
                $("#modal_bg").css("display","flex");
                $("#close_modal").click(function() {
                    $("#modal_bg").css("display","none");
                });
            }
        })
    }

</script>
</body>
</html>