const logVm = new Vue({
  el: '#log',
  data: {
    row: {},
    logList: [],
    type: '',
    types: '',
    qq: '',
  },
  methods: {
    get: function (page, a) {
      data = { page: page, type: this.type, types: this.types, qq: this.qq }
      this.$http
        .post('/apisub.php?act=loglist', data, { emulateJSON: true })
        .then(function (data) {
          if (data.data.code == 1) {
            this.row = data.body
            this.logList = data.body.data
            if (a == 1) {
              toastr.success('查询成功')
            }
          } else {
            toastr.error(data.data.msg)
          }
        })
    },
  },
  mounted() {
    this.get(1)
  },
})
