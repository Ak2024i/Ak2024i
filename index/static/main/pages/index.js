// 上级迁移方法
$('#sjqy').click(function () {
  $('#modal_sjqy').modal('show')
  const btn = document.querySelector('#sjqyBtn')
  btn.onclick = () => {
    showBtnLoading(btn)
    const uid = document.querySelector('#sjqyUidInput').value
    const yqm = document.querySelector('#sjqyYqmInput').value
    $.ajax({
      type: 'POST',
      url: '../apisub.php?act=sjqy',
      data: { uid: uid, yqm: yqm },
      dataType: 'json',
      success: function (data) {
        if (data.code == 1) {
          closeBtnLoading(btn)
          $('#modal_sjqy').modal('hide')
          toastr.success(data.msg)
        } else {
          closeBtnLoading(btn)
          toastr.error(data.msg)
        }
      },
    })
  }
})

// 退出登录
$('#logout').click(function () {
  Swal.fire({
    text: '您确定要退出登录吗？',
    icon: 'warning',
    buttonsStyling: false,
    showCancelButton: true,
    confirmButtonText: '确认退出',
    cancelButtonText: '取消',
    customClass: {
      confirmButton: 'btn btn-primary',
      cancelButton: 'btn',
    },
  }).then(t => {
    t.isConfirmed &&
      toastr.success('退出登录成功') &&
      (window.location = '../apisub.php?act=logout')
  })
})

// 工单
$('#gdBtn').click(function () {
  window.location = './workorder'
})

// 检查是否存在已回复邮件
setTimeout(() => {
  function getIsHasNewReply() {
    $.post('/gd.php?act=gdlist').then(function (data) {
      if (data.code == 1) {
        for (let i = 0; i < data.data.length && i < 5; i++) {
          if (data.data[i].state == '已回复') {
            return (document.querySelector('#workOrderDot').style.display =
              'block')
          }
        }
      } else {
        toastr.error('获取数据失败')
      }
    })
  }
  getIsHasNewReply()
}, 2000)
