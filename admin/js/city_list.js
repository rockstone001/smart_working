$(function () {

    //1.初始化Table
    window.oTable = new TableInit();
    oTable.Init();

    //2.初始化Button的点击事件
    var oButtonInit = new ButtonInit();
    oButtonInit.Init();

    //
    $('#btn_add').click(function(){
        location.href = $(this).attr('data-link');
    });

    $('#btn_delete').click(function(){
        var toRemoveElems = $('#post_list').bootstrapTable('getSelections');
        if (toRemoveElems.length == 0) {
            $('#operate_dialog .modal-body').html('请选择要删除的城市!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
        } else {
            $('#remove_dialog .modal-body').html('您确定要删除这些城市吗?');
            $('#remove_dialog').modal({backdrop: 'static'});
            $('.cancel-btn').prop({'disabled':false});
            $('.confirm-btn').prop({'disabled':false});
        }
    });

    $('#btn_edit').click(function() {
        var toRemoveElems = $('#post_list').bootstrapTable('getSelections');
        if (toRemoveElems.length == 0) {
            $('#operate_dialog .modal-body').html('请选择要编辑的城市!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
        } else if (toRemoveElems.length > 1) {
            $('#operate_dialog .modal-body').html('一次只能编辑一个城市!');
            $('#operate_dialog').modal({backdrop: 'static'});
            setTimeout(function(){$("#operate_dialog").modal("hide")}, 2000);
        } else {
            location.href = $(this).attr('data-link') + '/' + toRemoveElems[0].id;
        }
    });
});

function doRemove()
{
    $('#remove_dialog .modal-body').html('正在删除, 请稍等......');
    $('.cancel-btn').prop({'disabled':true});
    $('.confirm-btn').prop({'disabled':true});

    var toRemoveElems = $('#post_list').bootstrapTable('getSelections');
    var post_ids = [];
    for (var i = 0; i < toRemoveElems.length; i ++) {
        post_ids.push(toRemoveElems[i].id);
    }
    $.post(remove_url, {post_ids:post_ids}, function(data) {
        if (data && data.code == 0) {
            $('#remove_dialog .modal-body').html('删除成功!');
            setTimeout(function(){
                $("#remove_dialog").modal("hide");
                $('#post_list').bootstrapTable('refresh', oTable.queryParams);
            }, 600);

        } else {
            $('#remove_dialog .modal-body').html(data.msg);
            setTimeout(function(){
                $("#remove_dialog").modal("hide");
            }, 600);
        }
    }, 'json');
}


var TableInit = function () {
    var oTableInit = new Object();
    //初始化Table
    oTableInit.Init = function () {
        $('#post_list').bootstrapTable({
            url: list_url,   //请求后台的URL（*）
            method: 'get',      //请求方式（*）
            toolbar: '#toolbar',    //工具按钮用哪个容器
            striped: true,      //是否显示行间隔色
            cache: false,      //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
            pagination: true,     //是否显示分页（*）
            sortable: false,      //是否启用排序
            sortOrder: "asc",     //排序方式
            queryParams: oTableInit.queryParams,//传递参数（*）
            sidePagination: "server",   //分页方式：client客户端分页，server服务端分页（*）
            pageNumber:1,      //初始化加载第一页，默认第一页
            pageSize: 10,      //每页的记录行数（*）
            pageList: [10, 25, 50, 100],  //可供选择的每页的行数（*）
            search:true,      //是否显示表格搜索，此搜索是客户端搜索，不会进服务端，所以，个人感觉意义不大
            strictSearch: true,
            showColumns: false,     //是否显示所有的列
            showRefresh: true,     //是否显示刷新按钮
            minimumCountColumns: 2,    //最少允许的列数
            clickToSelect: true,    //是否启用点击选中行
            //height: 500,      //行高，如果没有设置height属性，表格自动根据记录条数觉得表格高度
            uniqueId: "id",      //每一行的唯一标识，一般为主键列
            showToggle:false,     //是否显示详细视图和列表视图的切换按钮
            cardView: false,     //是否显示详细视图
            detailView: false,     //是否显示父子表
            columns: [{
                checkbox: true
            }, {
                field: 'name',
                title: '城市名'
            }, {
                field: 'company',
                title: '所属分公司'
            }]
        });
    };

    //得到查询的参数
    oTableInit.queryParams = function (params) {
        //console.log(params);
        var temp = { //这里的键的名字和控制器的变量名必须一直，这边改动，控制器也需要改成一样的
            limit: params.limit, //页面大小
            offset: params.offset, //页码
            name: params.search //搜索关键字
        };
        return temp;
    };
    return oTableInit;
};


var ButtonInit = function () {
    var oInit = new Object();
    var postdata = {};

    oInit.Init = function () {
        //初始化页面上面的按钮事件
    };

    return oInit;
};