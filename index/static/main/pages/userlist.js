const userListVm = new Vue({
  el: '#userlist',
  data() {
    return {
      row: {},
      userList: [],
      type: '1',
      qq: '',
      addprice: '',
      row1: '',
      yqmInfo: {
        uid: '',
        yqm: '',
        name: '',
      },
      czInfo: {
        name: '',
        money: '',
      },
      addForm: {
        name: '',
        user: '',
        pass: '',
        addprice: '',
      },
      updateForm: {
        uid: '',
        addprice: '',
      },
    }
  },
  methods: {
    get: function (page) {
      this.$http
        .post(
          '/apisub.php?act=userlist',
          { type: this.type, qq: this.qq, page: page },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            this.row = data.body
            this.userList = data.body.data
          } else {
            toastr.error(data.data.msg)
          }
        })
    },
    dj: function () {
      this.$http
        .post('/apisub.php?act=adddjlist', { emulateJSON: true })
        .then(function (data) {
          if (data.data.code == 1) {
            this.row1 = data.body
          } else {
            toastr.error(data.data.msg)
          }
        })
    },
    handleAdd: function () {
      const btn = document.querySelector('#addSubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/apisub.php?act=adduser',
        { data: this.addForm },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            Swal.fire({
              text: data.msg,
              icon: 'warning',
              buttonsStyling: false,
              showCancelButton: true,
              confirmButtonText: '确认开通',
              cancelButtonText: '取消',
              customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn',
              },
            }).then(t => {
              t.isConfirmed &&
                userListVm.$http
                  .post(
                    '/apisub.php?act=adduser',
                    { data: userListVm.addForm, type: 1 },
                    { emulateJSON: true }
                  )
                  .then(function (data) {
                    if (data.data.code == 1) {
                      $('#modal_add').modal('hide')
                      userListVm.get(userListVm.row.current_page)
                      toastr.success(data.data.msg)
                    } else {
                      toastr.error(data.data.msg)
                    }
                  })
            })
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
    handleMenu: function (command) {
      const { res, type } = command
      if (type == 'cz') {
        this.czInfo.uid = res.uid
        this.czInfo.name = res.name
        this.cz()
      } else if (type == 'changeLevel') {
        this.updateForm = res
        $('#modal_update').modal('show')
      } else if (type == 'czmm') {
        this.czmm(res.uid)
      }
    },
    cz: function () {
      $('#modal_zhcz').modal('show')
      const btn = document.querySelector('#czBtn')
      btn.onclick = () => {
        showBtnLoading(btn)
        $.post(
          '/apisub.php?act=userjk',
          { uid: userListVm.czInfo.uid, money: userListVm.czInfo.money },
          function (data) {
            if (data.code == 1) {
              closeBtnLoading(btn)
              $('#modal_zhcz').modal('hide')
              toastr.success(data.msg)
              userListVm.czInfo.money = ''
              userListVm.get(userListVm.row.current_page)
            } else {
              closeBtnLoading(btn)
              toastr.error(data.msg)
            }
          }
        )
      }
    },
    handleUpdate: function () {
      const btn = document.querySelector('#updateSubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/apisub.php?act=usergj',
        { data: this.updateForm },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            Swal.fire({
              text: data.msg,
              icon: 'warning',
              buttonsStyling: false,
              showCancelButton: true,
              confirmButtonText: '确认开通',
              cancelButtonText: '取消',
              customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn',
              },
            }).then(t => {
              t.isConfirmed &&
                userListVm.$http
                  .post(
                    '/apisub.php?act=usergj',
                    { data: userListVm.updateForm, type: 1 },
                    { emulateJSON: true }
                  )
                  .then(function (data) {
                    if (data.data.code == 1) {
                      $('#modal_update').modal('hide')
                      userListVm.get(userListVm.row.current_page)
                      toastr.success(data.data.msg)
                    } else {
                      toastr.error(data.data.msg)
                    }
                  })
            })
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
    czmm: function (uid) {
      Swal.fire({
        text: '您确定要重置该用户的密码吗？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认重置',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          this.$http
            .post('/apisub.php?act=user_czmm', { uid }, { emulateJSON: true })
            .then(function (data) {
              if (data.data.code == 1) {
                userListVm.get(userListVm.row.current_page)
                toastr.success(data.data.msg)
              } else {
                toastr.error(data.data.msg)
              }
            })
      })
    },
    ktapi: function (uid) {
      Swal.fire({
        text: '给下级开通API，将扣除5元余额',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认开通',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          axios
            .get('/apisub.php?act=ktapi&type=2&uid=' + uid)
            .then(function (data) {
              if (data.data.code == 1) {
                userListVm.get(userListVm.row.current_page)
                toastr.success(data.data.msg)
              } else {
                toastr.error(data.data.msg)
              }
            })
      })
    },
    yqm: function (res) {
      this.yqmInfo.uid = res.uid
      this.yqmInfo.name = res.name
      $('#modal_yqm').modal('show')
      const btn = document.querySelector('#yqmBtn')
      btn.onclick = () => {
        showBtnLoading(btn)
        $.post(
          '/apisub.php?act=szyqm',
          { uid: userListVm.yqmInfo.uid, yqm: userListVm.yqmInfo.yqm },
          function (data) {
            if (data.code == 1) {
              closeBtnLoading(btn)
              $('#modal_yqm').modal('hide')
              toastr.success(data.msg)
              userListVm.yqmInfo.yqm = ''
              userListVm.get(userListVm.row.current_page)
            } else {
              closeBtnLoading(btn)
              toastr.error(data.msg)
            }
          }
        )
      }
    },
    ban: function (uid, active) {
      Swal.fire({
        text: '您确定要修改该用户的账户状态吗？',
        icon: 'warning',
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: '确认修改',
        cancelButtonText: '取消',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn',
        },
      }).then(t => {
        t.isConfirmed &&
          $.post('/apisub.php?act=user_ban', { uid, active }, function (data) {
            if (data.code == 1) {
              userListVm.get(userListVm.row.current_page)
              toastr.success(data.msg)
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
  },
  mounted() {
    this.get(1)
    this.dj()
  },
})
