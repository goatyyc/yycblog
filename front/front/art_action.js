//接收传参，渲染markdown文章
function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}

function apply_article(path) {
    marked.setOptions({
        renderer: new marked.Renderer(),
        gfm: true,
        tables: true,
        escaped : true,
        breaks: false,
        pedantic: false,
        sanitize: false,
        smartLists: true,
        smartypants: false,
        highlight: function (code, lang) {
            return hljs.highlightAuto(code).value;
        }
    });
    let md = $.ajax({
        url:path,async:false
    });
    console.log(md['responseText']);
    document.getElementById('main').innerHTML =
        marked(md['responseText']);
}