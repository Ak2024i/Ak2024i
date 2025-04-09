const chargeVm = new Vue({
  el: '#charge',
  data: {},
  methods: {
    szgg: function () {
      const btn = document.querySelector('#myNoticeBtn')
      showBtnLoading(btn)
      const notice = document.querySelector('#notice').value
      $.post('/apisub.php?act=user_notice', { notice }, function (data) {
        if (data.code == 1) {
          closeBtnLoading(btn)
          toastr.success(data.msg)
        } else {
          closeBtnLoading(btn)
          toastr.error(data.msg)
        }
      })
    },
  },
  mounted() {},
})
