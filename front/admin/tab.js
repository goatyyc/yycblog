//显示标签
function show_label() {
    $.ajax({
        url:"/yycblog/index.php/AdminAction/get_cate",
        type:"get",
        success: function (data) {
            //dom显示到页面
            if(data.code){
                var op_0 = "<option value=0>"+"请选择"+"</option>";
                var op = "";
                for(let i=0; i<data.data.length; i++){
                    op += "<option value="+data.data[i]['id']+">"+data.data[i]['label_name']+"</option>";
                }
                op = op_0+op;
                // console.log(op);
                document.getElementById("label_id").innerHTML = op;
            }
        }
    })
}

function tag() {
    let li = document.getElementsByClassName("navI");
    let div = document.getElementsByClassName("sort");

    for(let i=0; i<li.length; i++){
        //设置元素数组下标
        li[i].index = i;

        //鼠标划过高亮显示
        li[i].onmouseover = function () {
            this.style.backgroundColor = 'yellow';
        };

        //鼠标点击显示内容
        li[i].onclick = function () {
            for(let j=0; j<div.length; j++){
                div[j].style.display = 'none';
            }
            div[this.index].style.display = 'block';
        };

        //鼠标移开恢复
        li[i].onmouseout = function () {
            li[i].style.backgroundColor = 'bisque';
        }

    }

    //标签管理
    li[2].onclick = function () {
        for(let j=0; j<div.length; j++){
            div[j].style.display = 'none';
        }
        div[this.index].style.display = 'block';
        show_label();
    };

    //文章管理
    li[3].onclick = function () {
        for(let j=0; j<div.length; j++){
            div[j].style.display = 'none';
        }
        div[this.index].style.display = 'block';
        show_all_article();
    }
}


//添加文章
function get_article() {
    //把表单数据转换为 对象
    function serializeObject(obj) {
        var result = {}; // 准备一个空对象
        var params = obj.serializeArray();
        $.each(params, function (index, value) {
            result[value.name] = value.value;
        });
        return result; // 将处理的结果返回到函数外部
    }
    var data = serializeObject($("#publish_article_form"));
    var aritcle_label_id = document.getElementById("article_label_id").value;       //标签分类的i
    // console.log(aritcle_label_id);
    //实例化一个表单对象，存储数据
    var form = new FormData();
    form.append('file',$('#article')[0].files[0]);      //添加图片信息参数
    form.append('label',aritcle_label_id);
    form.append('title',data.title);

    $.ajax({
        url:"/yycblog/index.php/AdminAction/add_article",
        type:"post",
        data:form,
        cache:false,        //不缓存
        processData:false,  //不处理发送的数据
        contentType:false,  //不设置content-type请求头

        success:function (data) {
            console.log(data);
            if(data.code){
                alert("发布成功");
            }else {
                alert("发布失败:"+data.msg);
            }
            document.getElementById("publish_article_form").reset();
        }

    })
}



//展示文章
function show_all_article() {
    $.ajax({
        url: '/yycblog/index.php/AdminAction/query_article',
        type: 'get',
        success:function (data) {
            // console.log(data);
            if(data.code){
                var li = "";
                for (let i=0; i<data.data.length; i++){

                    let art_id = data.data[i]['id'];
                    li += "<tr>"+"<td>"+
                        data.data[i]['title']+"</td>"+
                        "<td>"+"<button onclick=delete_article("+art_id+")>删除</button>"+"</td>"
                        +"</tr>";
                }
                // console.log(li);
                document.getElementById("article_table").innerHTML = li;

            }
        }
    })
}

//删除文章
function delete_article(article_id){
    //ajax调用删除文章接口
    // console.log(article_id);
    $.ajax({
        url:"/yycblog/index.php/AdminAction/delete_article?article_id="+article_id,
        type:"get",
        success:function (data) {
            if(data.code){
                show_all_article();
                alert("删除成功");
            }
        }
    })
}

//清空表单
function formReset()
{
    document.getElementById("myForm").reset();
}

function submitForm() {
    var label_name = document.getElementById("label_name").value;
    var label_id = document.getElementById("label_id").value;
    var data = {"label_name":label_name,"label_id":label_id};
    // console.log(data);
    $.ajax({
        url:"/yycblog/index.php/AdminAction/add_cate",
        type:"post",
        data: data,
        success: function (data) {
            if(data.code){
                alert("发布成功");
            }else {
                alert(data.msg);
            }
        }

    });

    document.getElementById("myForm").reset();
}



window.onload = function() {
    tag();              //tag切换

    //文章标签
    $.ajax({
        url:"/yycblog/index.php/AdminAction/get_cate",
        type:"get",
        success: function (data) {
            //dom显示到页面
            if(data.code){
                var op_0 = "<option value=0>"+"请选择"+"</option>";
                var op = "";
                for(let i=0; i<data.data.length; i++){
                    op += "<option value="+data.data[i]['id']+">"+data.data[i]['label_name']+"</option>";
                }
                op = op_0+op;
                document.getElementById("article_label_id").innerHTML = op;
            }
        }
    })
};