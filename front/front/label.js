window.onload = function () {
    get_cate();

};

function get_cate() {
    $.ajax({
        url:"/yycblog/index.php/ArticleAction/level_label?pid=0",
        type:"get",
        success:function (data) {
            if(data.code){
                console.log(data);
                var li = "";
                var label = document.getElementById("label_id");
                for(let i=0; i<data.data.length; i++){
                    li += "<li class='cate' onclick='get_label_article("+data.data[i]['id']+")'>"+data.data[i]['label_name']+"</li>";
                }
                label.innerHTML = li;
            }
        }
    })
}

// function add_seconde_label(id) {
//     //渲染二级标签
//     $.ajax({
//         url:"/yycblog/index.php/ArticleAction/level_label?pid="+id,
//         type:"get",
//         success: function (data) {
//             if(data.code){
//                 console.log(data);
//                 var li = "";
//                 var label = document.getElementById("second_label");
//                 for(let i=0; i<data.data.length; i++){
//                     li += "<li class='cate' onclick='get_label_article("+data.data[i]['id']+")'>"+data.data[i]['label_name']+"</li>";
//                 }
//                 label.innerHTML = li;
//             }
//         }
//     })
//
// }

function get_article_by_id(id) {
    //根据所有标签id获取相关文章
    //js数组转化为json

    // console.log(11111);
    var data = JSON.stringify(id);
    console.log(data);
    $.ajax({
        url:"/yycblog/index.php/ArticleAction/query_article_by_id",
        type:"post",
        dataType:"json",
        data:data,
        success: function (data) {
            if (data.code){
                var li = "";
                console.log(data.data);
                for(let i=0;i<data.data.length;i++){
                    for(let j=0;j<data.data[i].length;j++){
                        var title = data.data[i][j]['title'];
                        var id = data.data[i][j]['id'];
                        //拼接标题，超链接
                        li += "<li>"+"<a target='_blank' href='article.html?id="+id+"'>"+title+"</a>"+"</li>";
                        // console.log(title);
                    }
                }
                var div = document.getElementById("article_id");
                div.innerHTML = li;
            }
        }
    })

    //ajax发送json数据有bug

}

function get_first_label_article(id) {
    //获取相关子标签id
    $.ajax({
        url:"/yycblog/index.php/ArticleAction/get_label_cate?id="+id,
        type:"get",
        success: function (data) {
            var arr = {};            //小坑，js的数组的{}而不是[]
            // console.log(data);
            for(let i=0;i<data.data.length;i++){
                arr[i] = data.data[i]['id'];
            }
            var val = String(id);
            arr[data.data.length] = val;
            // console.log(arr);

            //获取相关文章
            get_article_by_id(arr);
        }
    })
}

function get_label_article(id) {
    //获取所有相关标签id
    var data = {'id':id};
    $.ajax({
        "url":"/yycblog/index.php/ArticleAction/get_label_cate",
        type: "get",
        data: data,
        success: function (data) {
            if (data.code){
                // add_seconde_label(id);
                //渲染相关标签下的文章
                console.log(data);
                get_first_label_article(id);
            }
        }
    });


}