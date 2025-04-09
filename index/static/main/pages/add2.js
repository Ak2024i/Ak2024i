const add2Vm = new Vue({
  el: '#add2',
  data: {
    row: [],
    check_row: [],
    userinfo: '',
    cid: '',
    id: '',
    miaoshua: '',
    class1: '',
    class3: '',
    show: false,
    show1: false,
    content: '',
    activems: false,
  },
  methods: {
    get: function () {
      if (this.cid == '' || this.userinfo == '') {
        layer.msg('所有项目不能为空')
        return false
      }
      userinfo = this.userinfo
        .replace(/\r\n/g, '[br]')
        .replace(/\n/g, '[br]')
        .replace(/\r/g, '[br]')
      userinfo = userinfo.split('[br]') //分割
      this.row = []
      this.check_row = []
      for (var i = 0; i < userinfo.length; i++) {
        info = userinfo[i]
        var hash = getENC('<?php echo $addsalt;?>')
        var loading = layer.load(2)
        this.$http
          .post(
            '/apisub.php?act=get',
            {
              cid: this.cid,
              userinfo: info,
              hash,
            },
            {
              emulateJSON: true,
            }
          )
          .then(function (data) {
            layer.close(loading)
            this.show1 = true
            this.row.push(data.body)
          })
      }
    },
    add: function () {
      if (this.cid == '') {
        layer.msg('请先查课')
        return false
      }
      if (this.check_row.length < 1) {
        layer.msg('请先选择课程')
        return false
      }
      //console.log(this.check_row);
      var loading = layer.load(2)
      this.$http
        .post(
          '/apisub.php?act=add',
          {
            cid: this.cid,
            data: this.check_row,
          },
          {
            emulateJSON: true,
          }
        )
        .then(function (data) {
          layer.close(loading)
          if (data.data.code == 1) {
            this.row = []
            this.check_row = []
            layer.alert(
              data.data.msg,
              {
                icon: 1,
                title: '温馨提示',
              },
              function () {
                setTimeout(function () {
                  window.location.href = ''
                })
              }
            )
          } else {
            layer.alert(data.data.msg, {
              icon: 2,
              title: '温馨提示',
            })
          }
        })
    },
    checkResources: function (userinfo, userName, rs, id, name) {
      for (i = 0; i < rs.length; i++) {
        if (id == '') {
          if (rs[i].name == name) {
            aa = rs[i]
          }
        } else {
          if (rs[i].id == id && rs[i].name == name) {
            aa = rs[i]
          }
        }
      }
      data = {
        userinfo,
        userName,
        data: aa,
      }
      if (this.check_row.length < 1) {
        vm.check_row.push(data)
      } else {
        var a = 0
        for (i = 0; i < this.check_row.length; i++) {
          if (
            vm.check_row[i].userinfo == data.userinfo &&
            vm.check_row[i].data.name == data.data.name
          ) {
            var a = 1
            vm.check_row.splice(i, 1)
          }
        }
        if (a == 0) {
          vm.check_row.push(data)
        }
      }
    },
    fenlei: function (id) {
      var load = layer.load(2)
      this.$http
        .post(
          '/apisub.php?act=getclassfl',
          {
            id: id,
          },
          {
            emulateJSON: true,
          }
        )
        .then(function (data) {
          layer.close(load)
          if (data.data.code == 1) {
            this.class1 = data.body.data
          } else {
            layer.msg(data.data.msg, {
              icon: 2,
            })
          }
        })
    },
    getclass: function () {
      var load = layer.load(2)
      this.$http.post('/apisub.php?act=getclass').then(function (data) {
        layer.close(load)
        if (data.data.code == 1) {
          this.class1 = data.body.data
        } else {
          layer.msg(data.data.msg, {
            icon: 2,
          })
        }
      })
    },
    tips: function (message) {
      for (var i = 0; this.class1.length > i; i++) {
        if (this.class1[i].cid == message) {
          this.show = true
          this.content = this.class1[i].content
          return false
          if (this.class1[i].miaoshua == 1) {
            this.activems = true
          } else {
            this.activems = false
          }
          return false
        }
      }
    },
    tips2: function () {
      layer.tips('开启秒刷将额外收0.05的费用', '#miaoshua')
    },
  },
  mounted() {
    this.getclass()
  },
})
