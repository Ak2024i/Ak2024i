const gdlistVm = new Vue({
  el: '#gdlist',
  data: {
    row: {},
    order: [],
    publicForm: {},
    userForm: { region: '', oid: '', title: '', content: '', answer: '' },
    addForm: {
      oid: '',
      title: '暂无标题',
      content: '',
      region: '',
    },
    adminControlInfo: {
      gid: '',
      region: '',
      title: '',
      answer: '',
    },
  },
  methods: {
    handleMenu: function (command) {
      const { res, type } = command
      if (type == 'reply') {
        this.adminControlInfo = res
        $('#modal_adminreply').modal('show')
      } else if (command.type == 'reblack') {
        this.adminControlInfo = res
        $('#modal_reblack').modal('show')
      } else if (command.type == 'close') {
        this.handleCloseAndUntreated(res.gid, 'close')
      } else if (command.type == 'untreated') {
        this.handleCloseAndUntreated(res.gid, 'untreated')
      } else if (command.type == 'delete') {
        this.handleDelete(res.gid)
      }
    },
    // 驳回工单
    handldeReBlack: function () {
      const btn = document.querySelector('#adminReBlackSubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/gd.php?act=bohui',
        {
          gid: this.adminControlInfo.gid,
          answer: this.adminControlInfo.answer,
        },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_reblack').modal('hide')
            toastr.success(data.msg)
            gdlistVm.get()
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
    // 管理员回复
    handldeReply: function () {
      const btn = document.querySelector('#adminReplySubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/gd.php?act=answer',
        {
          gid: this.adminControlInfo.gid,
          answer: this.adminControlInfo.answer,
        },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_adminreply').modal('hide')
            toastr.success(data.msg)
            gdlistVm.get()
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
    // 关闭工单和不处理工单
    handleCloseAndUntreated: function (gid, type) {
      //关闭工单
      if (type == 'close') {
        $.post('/gd.php?act=gbgd', { gid: gid }, function (data) {
          if (data.code == 1) {
            toastr.success(data.msg)
            gdlistVm.get()
          } else {
            toastr.error(data.msg)
          }
        })
      }
      //不处理工单
      if (type == 'untreated') {
        $.post('/gd.php?act=bclgd', { gid: gid }, function (data) {
          if (data.code == 1) {
            toastr.success(data.msg)
            gdlistVm.get()
          } else {
            toastr.error(data.msg)
          }
        })
      }
    },
    //获取工单列表
    get: function () {
      data = { list: this.userForm }
      this.$http
        .post('/gd.php?act=gdlist', data, { emulateJSON: true })
        .then(function (data) {
          if (data.data.code == 1) {
            this.row = data.body
            this.row.current_page = 1
            this.order = data.body.data
            // for (var i = 0; data.body.data.length > i; i++) {
            //   this.order[i] = data.body.data[i]
            // }
          } else {
            toastr.error(data.msg)
          }
        })
    },
    //提交工单
    handleAdd: function () {
      // 获取 select 选项
      const region = $('#addFormRegion option:selected').val()
      this.addForm.region = region
      const btn = document.querySelector('#addSubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/gd.php?act=addgd',
        {
          oid: this.addForm.oid,
          title: this.addForm.title,
          region: this.addForm.region,
          content: this.addForm.content,
        },
        { emulateJSON: true }
      ).then(function (data) {
        if (data.code == 1) {
          closeBtnLoading(btn)
          $('#modal_add').modal('hide')
          toastr.success(data.msg)
          gdlistVm.get()
        } else {
          closeBtnLoading(btn)
          toastr.error(data.msg)
        }
      })
    },
    //删除工单
    handleDelete: function (gid) {
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
          $.post('/gd.php?act=shan', { gid: gid }, function (data) {
            if (data.code == 1) {
              toastr.success(data.msg)
              gdlistVm.get()
            } else {
              toastr.error(data.msg)
            }
          })
      })
    },
    //工单二次回复
    handleToAnswer: function () {
      const btn = document.querySelector('#userReplySubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/gd.php?act=toanswer',
        { gid: this.userForm.gid, toanswer: this.userForm.content },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_userreply').modal('hide')
            toastr.success(data.msg)
            gdlistVm.get()
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
    userReplyInit(res) {
      this.userForm = res
    },
    // 查看详情
    check: function (res) {
      this.publicForm = res
    },
  },
  mounted() {
    this.get()
  },
})
