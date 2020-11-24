function show_article(page) {
    $.ajax({
        // url:"/yycblog/index.php/AdminAction/show_article?page="+page,
        url:"/yycblog/index.php/ArticleAction/show_article?page="+page,
        type: "get",
        success:function (data) {
            console.log(data);
            if(data.code){
                //文章标题拼接
                var li = "";
                for(let i=0; i<data.data.lists.length;i++){
                    var id = data.data.lists[i]['id'];
                    var title = data.data.lists[i]['title'];
                    li += "<li>"+"<a target='_blank' href='article.html?id="+id+"'>"+title+"</li>";
                }
                console.log(data);
                document.getElementById("article").innerHTML = li;

                //渲染分页栏
                load_page();
            }
        }
    })
}

//分页栏
function load_page() {
    let page = "";
    $.ajax({
        type: 'GET',
        // url:'/yycblog/index.php/AdminAction/query_article',
        url:'/yycblog/index.php/ArticleAction/query_article',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            let num = Math.ceil(data.data.length/6);
            console.log(num);
            //循环展示num个标签
            for(let i=1; i<=num; i++){
                let id = i;
                page += "<li onclick='show_page("+id+")'>"+i+"</li>";
            }
            page += "<li>»</li>";
            $("#page").html(page);
        }
    })
}

//第i页文章
function show_page(id)
{
    //调用第id页的文章
    show_article(id);

}

//获取所有文章
function get_all_articles() {
    $.ajax({
        // url:"/yycblog/index.php/AdminAction/query_article",
        url:"/yycblog/index.php/ArticleAction/query_article",
        type: "get",
        success:function (data) {
            console.log(data);
            if(data.code){
                //文章标题拼接
                var li = "";
                for(let i=0; i<data.data.lists.length;i++){
                    var id = data.data.lists[i]['id'];
                    var title = data.data.lists[i]['title'];
                    li += "<li>"+"<a target='_blank' href='article.html?id="+id+"'>"+title+"</li>";
                }
                console.log(data);
                document.getElementById("article").innerHTML = li;
            }
        }
    })
}


window.onload=function ()
{

    tab();              //tab切换
    show_cloud();
    // show_labels();   //标签展示存在bug 不能和词云兼容，先写死

    //显示首页文章，每页6条
    show_article(1);

    //分页栏


};


function show_labels() {
    $.ajax({
        // url:"/yycblog/index.php/AdminAction/get_cate",
        url:"/yycblog/index.php/ArticleAction/get_cate",
        type:"get",
        success: function (data) {
            //dom显示到页面
            if(data.code){
                var op = "";
                for(let i=0; i<data.data.length; i++){
                    op += '<a href="">'+data.data[i]['label_name']+'</a>';
                }
                console.log(op);
                document.getElementById("cloud").innerHTML = op;
            }
        }
    })
}