const fenleiVm = new Vue({
  el: '#fenlei',
  data: {
    row: {},
    cateList: [],
    addForm: {
      sort: '',
      name: '',
    },
    updateForm: {
      id: '',
      sort: '',
      name: '',
      status: '',
    },
  },
  methods: {
    get: function (page) {
      this.$http.post('/apisub.php?act=fllist').then(function (data) {
        if (data.data.code == 1) {
          this.row = data.body
          this.row.current_page = 1
          this.cateList = data.body.data
        } else {
          toastr.error(data.data.msg)
        }
      })
    },
    handleAdd: function () {
      const btn = document.querySelector('#addSubmitBtn')
      showBtnLoading(btn)
      this.$http
        .post(
          '/apisub.php?act=fl',
          { data: this.addForm, active: 1 },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_add').modal('hide')
            toastr.success(data.data.msg)
            this.get(1)
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
    handleUpdate: function () {
      const btn = document.querySelector('#updateSubmitBtn')
      showBtnLoading(btn)
      this.$http
        .post(
          '/apisub.php?act=fl',
          { data: this.updateForm, active: 2 },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_update').modal('hide')
            toastr.success(data.data.msg)
            this.get(1)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.data.msg)
          }
        })
    },
    del: function (id) {
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
            .post('/apisub.php?act=fl_del', { id: id }, { emulateJSON: true })
            .then(function (data) {
              if (data.data.code == 1) {
                this.get(1)
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
