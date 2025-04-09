const classVm = new Vue({
  el: '#class',
  data: {
    row: [],
    classList: [],
    addForm: {
      action: 'add',
      sort: '',
      name: '',
      price: '',
      getnoun: '',
      noun: '',
      queryplat: '',
      docking: '',
      status: '',
      fenlei: '',
      content: '',
    },
    updateForm: {
      action: 'update',
      cid: '',
      sort: '',
      name: '',
      price: '',
      getnoun: '',
      noun: '',
      queryplat: '',
      docking: '',
      yunsuan: '',
      status: '',
      fenlei: '',
      content: '',
    },
  },
  methods: {
    get: function (page) {
      this.$http
        .post(
          '/apisub.php?act=classlist',
          { page: page },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            this.row = data.body
            this.classList = data.body.data
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
          '/apisub.php?act=upclass',
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
          '/apisub.php?act=upclass',
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
  },
  mounted() {
    this.get(1)
  },
})
