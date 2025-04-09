const huoyuanVm = new Vue({
  el: '#huoyuan',
  data: {
    row: {},
    apiList: [],
    addForm: {
      action: 'add',
      name: '',
      pt: '',
      url: '',
      user: '',
      pass: '',
      token: '',
      cookie: '',
    },
    updateForm: {
      action: 'update',
      hid: '',
      name: '',
      pt: '',
      url: '',
      user: '',
      pass: '',
      token: '',
      cookie: '',
    },
  },
  methods: {
    get: function (page) {
      this.$http
        .post(
          '/apisub.php?act=huoyuanlist',
          { page: page },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            this.row = data.body
            this.apiList = data.body.data
          } else {
            toastr.error(data.data.msg)
          }
        })
    },
    handleAdd: function () {
      const btn = document.querySelector('#addSubmitBtn')
      showBtnLoading(btn)
      // 设置 select
      this.addForm.pt = document.querySelector('#addFromPt').value
      this.$http
        .post(
          '/apisub.php?act=uphuoyuan',
          { data: this.addForm },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_add').modal('hide')
            toastr.success(data.data.msg)
            this.get(this.row.current_page)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.data.msg)
          }
        })
    },
    handleUpdate: function () {
      const btn = document.querySelector('#updateSubmitBtn')
      showBtnLoading(btn)
      this.$http
        .post(
          '/apisub.php?act=uphuoyuan',
          { data: this.updateForm },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_update').modal('hide')
            toastr.success(data.data.msg)
            this.get(this.row.current_page)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.data.msg)
          }
        })
    },
    edit: function (res) {
      this.updateForm = {}
      this.updateForm = res
    },
    del: function (hid) {
      Swal.fire({
        text: '您确定要删除吗？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认删除',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          this.$http
            .post('/apisub.php?act=hy_del', { hid: hid }, { emulateJSON: true })
            .then(function (data) {
              if (data.data.code == 1) {
                huoyuanVm.get(1)
                toastr.success(data.data.msg)
              } else {
                toastr.error(data.data.msg)
              }
            })
      })
    },
  },
  mounted() {
    this.get(1)
  },
})
