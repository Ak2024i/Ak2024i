const websetVm = new Vue({
  el: '#webset',
  data: {},
  methods: {
    handleSave: function () {
      const btn = document.querySelector('#saveBtn')
      showBtnLoading(btn)
      this.$http
        .post(
          '/apisub.php?act=webset',
          { data: $('#form-web').serialize() },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            toastr.success(data.data.msg)
            // setTimeout(() => {
            //   location.reload()
            // }, 1000)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.data.msg)
          }
        })
    },
  },
  mounted() {},
})
