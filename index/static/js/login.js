'use strict'
var KTSigninGeneral = (function () {
  var e, t, i
  return {
    init: function () {
      ;(e = document.querySelector('#kt_sign_in_form')),
        (t = document.querySelector('#kt_sign_in_submit')),
        (i = FormValidation.formValidation(e, {
          fields: {
            email: {
              validators: {
                notEmpty: { message: 'Email address is required' },
                emailAddress: {
                  message: 'The value is not a valid email address',
                },
              },
            },
            account: {
              validators: { notEmpty: { message: '账号不能为空' } },
            },
            password: {
              validators: { notEmpty: { message: '密码不能为空' } },
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
              rowSelector: '.fv-row',
              eleInvalidClass: '',
              eleValidClass: '',
            }),
          },
        })),
        t.addEventListener('click', function (n) {
          n.preventDefault(),
            i.validate().then(function (i) {
              'Valid' == i
                ? (t.setAttribute('data-kt-indicator', 'on'),
                  (t.disabled = !0),
                  loginVm.login())
                : Swal.fire({
                    text: '账号或密码不能为空！',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: '确认',
                    customClass: { confirmButton: 'btn btn-primary' },
                  })
            })
        })
    },
  }
})()
KTUtil.onDOMContentLoaded(function () {
  KTSigninGeneral.init()
})

var loginVm = new Vue({
  el: '#login',
  data: {
    user: {},
    authPass: '',
  },
  methods: {
    login: function () {
      const btn = document.querySelector('#kt_sign_in_submit')
      loginVm.$http
        .post(
          '/apisub.php?act=login',
          {
            user: this.user.account,
            pass: this.user.pass,
          },
          {
            emulateJSON: true,
          }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            toastr.success(data.data.msg)
            setTimeout(function () {
              window.location.href = '/index/index'
            }, 1000)
          } else if (data.data.code == 5) {
            btn.removeAttribute('data-kt-indicator')
            btn.disabled = !1
            // 展示弹窗
            $('#modal_auth').modal('show')
            setTimeout(function () {
              $('#authInput').focus()
            }, 500)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.data.msg)
          }
        })
    },
    login2: function () {
      const btn = document.querySelector('#authloginbtn')
      showBtnLoading(btn)
      loginVm.$http
        .post(
          '/apisub.php?act=login',
          {
            user: loginVm.user.account,
            pass: loginVm.user.pass,
            pass2: loginVm.authPass,
          },
          {
            emulateJSON: true,
          }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            $('#modal_auth').modal('hide')
            toastr.success(data.data.msg)
            setTimeout(function () {
              window.location.href = '/index/index'
            }, 1000)
          } else {
            closeBtnLoading(btn)
            toastr.error(data.data.msg)
          }
        })
    },
  },
})

$('#connect_qq').click(function () {
  $.ajax({
    type: 'POST',
    url: '../qq_login.php',
    data: {
      type: 'qq',
    },
    dataType: 'json',
    success: function (data) {
      if (data.code == 1) {
        window.location.href = data.url
      } else {
        toastr.error(data.msg)
      }
    },
  })
})
