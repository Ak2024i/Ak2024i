const passwdVm = new Vue({
  el: '#passwd',
  data: {
    oldpass: '',
    newpass: '',
  },
  methods: {
    passwd: function () {
      const btn = document.querySelector('#repwd')
      showBtnLoading(btn)
      if (!this.oldpass || !this.newpass) {
        closeBtnLoading(btn)
        return toastr.error('旧密码和新密码不能为空')
      }
      $.post(
        '/apisub.php?act=passwd',
        { oldpass: this.oldpass, newpass: this.newpass },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            toastr.success('修改成功，请重新登录')
            setTimeout(() => {
              window.location.href = '/index/login'
            }, 2000)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
  },
})
