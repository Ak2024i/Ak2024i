const listVm = new Vue({
  el: '#list',
  data: {
    row: {},
    orderList: [],
    phone: '',
    sex: [],
    orderInfo: [],
    dc: [],
    dc2: {
      gs: 1,
    },
    cx: {
      status_text: '',
      dock: '',
      qq: '',
      oid: '',
      uid: '',
      cid: '',
    },
  },
  methods: {
    handleMenu: function (command) {
      const { res, type } = command
      if (type == 'refresh') {
        this.up(res.oid)
      } else if (type == 'restart') {
        this.bs(res.oid)
      } else if (type == 'quit') {
        this.quxiao(res.oid)
      } else if (type == 'check') {
        this.checkOrder(res)
      }
    },
    get: function (page, a) {
      data = { cx: this.cx, page }
      this.$http
        .post('/apisub.php?act=orderlist', data, { emulateJSON: true })
        .then(function (data) {
          if (data.data.code == 1) {
            this.row = data.body
            this.orderList = data.body.data
            if (a == 1) {
              toastr.success('查询成功')
            }
          } else {
            toastr.error(data.data.msg)
          }
        })
    },
    bs: function (oid) {
      Swal.fire({
        text: '建议漏看或者进度被重置的情况下使用，您确定要提交补学吗？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认提交',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          $.get('/apisub.php?act=bs&oid=' + oid, function (data) {
            if (data.code == 1) {
              listVm.get(listVm.row.current_page)
              toastr.success(data.msg)
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
    up: function (oid) {
      $.get('/apisub.php?act=uporder&oid=' + oid, function (data) {
        if (data.code == 1) {
          listVm.get(listVm.row.current_page)
          setTimeout(function () {
            for (i = 0; i < listVm.row.data.length; i++) {
              if (listVm.row.data[i].oid == oid) {
                listVm.orderInfo = listVm.row.data[i]
                return true
              }
            }
          }, 1800)
          toastr.success(data.msg)
        } else {
          toastr.error(data.msg)
        }
      })
    },
    duijie: function (oid) {
      Swal.fire({
        text: '您确定处理么？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认提交',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          $.get('/apisub.php?act=duijie&oid=' + oid, function (data) {
            if (data.code == 1) {
              listVm.get(listVm.row.current_page)
              toastr.success(data.msg)
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
    getname: function (oid) {
      $.get('/apisub.php?act=getname&oid=' + oid, function (data) {
        if (data.code == 1) {
          toastr.success(data.msg)
        } else {
          toastr.error(data.msg)
        }
      })
    },
    ms: function (oid) {
      Swal.fire({
        text: '提交秒刷将扣除0.05元服务费？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认提交',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          $.get('/apisub.php?act=ms_order&oid=' + oid, function (data) {
            if (data.code == 1) {
              listVm.get(listVm.row.current_page)
              toastr.success(data.msg)
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
    quxiao: function (oid) {
      Swal.fire({
        text: '取消订单将无法退款，确定要取消吗？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认提交',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          $.get('/apisub.php?act=qx_order&oid=' + oid, function (data) {
            if (data.code == 1) {
              listVm.get(listVm.row.current_page)
              toastr.success(data.msg)
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
    status_text: function (a) {
      $.post(
        '/apisub.php?act=status_order&a=' + a,
        { sex: this.sex, type: 1 },
        { emulateJSON: true }
      ).then(function (data) {
        if (data.code == 1) {
          listVm.selectAll()
          listVm.get(listVm.row.current_page)
          toastr.success(data.msg)
        } else {
          toastr.error(data.msg)
        }
      })
    },
    dock: function (a) {
      $.post(
        '/apisub.php?act=status_order&a=' + a,
        { sex: this.sex, type: 2 },
        { emulateJSON: true }
      ).then(function (data) {
        if (data.code == 1) {
          listVm.selectAll()
          listVm.get(listVm.row.current_page)
          toastr.success(data.msg)
        } else {
          toastr.error(data.msg)
        }
      })
    },
    selectAll: function () {
      if (this.sex.length == 0) {
        for (i = 0; i < listVm.row.data.length; i++) {
          listVm.sex.push(this.row.data[i].oid)
        }
      } else {
        this.sex = []
      }
    },
    checkOrder: function (res) {
      this.orderInfo = res
      $('#modal_check').modal('show')
    },
    tk: function (sex) {
      if (this.sex == '') {
        toastr.error('请先选择订单！')
        return false
      }

      Swal.fire({
        text: '确定要退款吗？陛下，三思三思！！！',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认退款',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          $.post(
            '/apisub.php?act=tk',
            { sex: sex },
            { emulateJSON: true }
          ).then(function (data) {
            if (data.code == 1) {
              listVm.selectAll()
              listVm.get(listVm.row.current_page)
              toastr.success(data.msg)
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
    daochu: function () {
      if (this.dc2.gs == '') {
        toastr.error('请先选择格式')
        return false
      }
      if (!this.sex[0]) {
        toastr.error('请先选择订单')
        return false
      }
      for (i = 0; i < this.sex.length; i++) {
        oid = this.sex[i]
        for (x = 0; x < this.row.data.length; x++) {
          if (this.row.data[x].oid == oid) {
            school = this.row.data[x].school
            user = this.row.data[x].user
            pass = this.row.data[x].pass
            kcname = this.row.data[x].kcname
            if (this.dc2.gs == '1') {
              a = school + ' ' + user + ' ' + pass + ' ' + kcname
            } else if (this.dc2.gs == '2') {
              a = user + ' ' + pass + ' ' + kcname
            } else if (this.dc2.gs == '3') {
              a = school + ' ' + user + ' ' + pass
            } else if (this.dc2.gs == '4') {
              a = user + ' ' + pass
            }
            this.dc.push(a)
          }
        }
      }
      $('#modal_dcorder').modal('show')
      // layer.alert(this.dc.join('<br>'))
      // this.dc = []
    },
    clearDcList: function () {
      this.dc = []
    },
  },
  mounted() {
    this.get(1)
  },
})
