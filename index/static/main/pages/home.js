let current = 0 // 当前用量

const homeVm = new Vue({
  el: '#home',
  data: {
    row: {},
    yqprice: '',
  },
  methods: {
    userinfo: function () {
      this.$http.post('/apisub.php?act=userinfo').then(function (data) {
        if (data.data.code == 1) {
          this.row = data.data
          if (data.data.key != 0) {
            current += 33.33
          }
          if (data.data.yqprice != '') {
            current += 33.33
          }
          if (data.data.qq_openid != '') {
            current += 33.33
          }
        } else {
          toastr.error(data.data.msg)
        }
      })
    },
    yecz: function () {
      toastr.error(
        '请联系您的上级QQ：' +
          this.row.sjuser +
          '，进行充值。（下级点充值，此处将显示您的QQ）'
      )
    },
    ktapi: function () {
      Swal.fire({
        text: '后台余额满300元可免费开通，反之需花费10元开通，您确定要继续开通吗？',
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
          axios.get('/apisub.php?act=ktapi&type=1').then(function (data) {
            if (data.data.code == 1) {
              toastr.success(data.data.msg)
              setTimeout(function () {
                window.location.reload()
              }, 2000)
            } else {
              toastr.error(data.data.msg)
            }
          })
      })
    },
    ghapi: function () {
      Swal.fire({
        text: '重置之后之前的就不能用了,确定更继续重置key吗？',
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
          axios.get('/apisub.php?act=ktapi&type=3').then(function (data) {
            if (data.data.code == 1) {
              toastr.success(data.data.msg)
              setTimeout(function () {
                window.location.reload()
              }, 2000)
            } else {
              toastr.error(data.data.msg)
            }
          })
      })
    },
    szyqprice: function () {
      const btn = document.querySelector('#yqPriceSubmitBtn')
      showBtnLoading(btn)
      $.post(
        '/apisub.php?act=yqprice',
        { yqprice: this.yqprice },
        function (data) {
          if (data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_szyqprice').modal('hide')
            homeVm.userinfo()
            toastr.success(data.msg)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.msg)
          }
        }
      )
    },
    connect_qq: function () {
      $.ajax({
        type: 'POST',
        url: '../qq_login.php',
        data: { type: 'qq' },
        dataType: 'json',
        success: function (data) {
          if (data.code == 1) {
            window.location.href = data.url
          } else {
            toastr.error(data.msg)
          }
        },
      })
    },
  },
  mounted() {
    this.userinfo()
  },
})

setTimeout(() => {
  let chart1 = echarts.init(document.getElementById('chart-renwu'))
  let all = 100 // 总量
  let option = {
    series: [
      {
        type: 'pie',
        label: {
          show: true,
          position: 'center',
          color: 'rgba(0, 163, 255, 0.85)',
          formatter: '{total|' + current + '%' + '}',
          rich: {
            total: {
              fontSize: 30,
              color: 'rgba(0, 163, 255, 0.85)',
            },
          },
        },
        center: ['50%', '50%'],
        radius: ['60%', '80%'],
        startAngle: 180,
        data: [
          {
            name: '用量',
            value: current,
            itemStyle: {
              color: 'rgba(0, 163, 255, 0.85)',
            },
          },
          {
            name: 'rest', // 实际显示部分是总量-用量
            value: all - current,
            itemStyle: {
              color: 'rgba(0, 163, 255, 0.1)',
            },
          },
          {
            name: 'bottom',
            value: all,
            itemStyle: {
              color: 'transparent',
            },
          },
        ],
      },
    ],
  }
  chart1.setOption(option)
}, 2000)
