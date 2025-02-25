function serviceTypeRadio(type) {
    $('#service_type').val(type);
}

// 上传多图回调函数
function uploadImgCallBack(paths) {
    var last_div = $(".upload_img_upload_tpl").html();
    var obj = $('#dl_upload_img');
    for (var i = 0; i < paths.length; i++) {
        // 若可上传数量为0则执行返回
        var num = obj.attr('data-numlimit');
        if (0 === parseInt(num)) return false;
        num = Number(num) - 1;
        obj.attr('data-numlimit', parseInt(num));
        obj.find(".fieldext_upload:eq(0)").before(last_div);
        obj.find(".fieldext_upload:eq(0)").find('input').val(paths[i]);
        obj.find(".fieldext_upload:eq(0)").find('a:eq(0)').attr('href', paths[i]).attr('target', "_blank");
        obj.find(".fieldext_upload:eq(0)").find('img').attr('src', paths[i]);
        obj.find(".fieldext_upload:eq(0)").find('a:eq(1)').attr('onclick', "uploadImgDel(this, '"+paths[i]+"')").text('删除');
    }             
}

// 上传之后删除组图input
function uploadImgDel(obj, path) {
    $(obj).parent().remove();
    $.ajax({
        type: 'POST',
        url : delUploadify_url,
        data: {action:"del", filename:path, '_ajax':1},
        success:function(){
            var imgObj = $('#dl_upload_img');
            var num = imgObj.attr('data-numlimit');
            num = Number(num) + 1;
            imgObj.attr('data-numlimit', parseInt(num));
        }
    });  
}

// 提交申请
function submitApply(obj) {
    if ($("#service_type").val() == '') {
        showLayerMsg('请选择服务类型');
        return false;
    } else if ($.trim($("[name='content']").val()) == '') {
        $("[name='content']").focus();
        showLayerMsg('请填写问题描述');
        return false;
    } else if ($("#consignee").val() == '') {
        $("[name='consignee']").focus();
        showLayerMsg('请填写您的姓名');
        return false;
    } else if ($("#mobile").val() == '') {
        $("[name='mobile']").focus();
        showLayerMsg('请填写您的手机号码');
        return false;
    } else if ($("#address").val() == '') {
        $("[name='address']").focus();
        showLayerMsg('请填写您的收货地址');
        return false;
    }

    showLayerLoad();
    $.ajax({
        url : $(obj).data('url'),
        data: $('#post_form').serialize(),
        type: 'post',
        dataType: 'json',
        success: function(res) {
            layer.closeAll();
            if (1 == res.code) {
                showLayerMsg(res.msg, 2, function() {
                    window.location.href = res.url;
                });
            } else {
                showLayerMsg(res.msg);
            }
        },
        error: function(e) {
            layer.closeAll();
            showLayerAlert(e.responseText);
        }
    });
}