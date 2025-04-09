'use strict'
var KTSignupGeneral = (function () {
  var e,
    t,
    a,
    s,
    r = function () {
      return 100 === s.getScore()
    }
  return {
    init: function () {
      ;(e = document.querySelector('#kt_sign_up_form')),
        (t = document.querySelector('#kt_sign_up_submit')),
        (s = KTPasswordMeter.getInstance(
          e.querySelector('[data-kt-password-meter="true"]')
        )),
        (a = FormValidation.formValidation(e, {
          fields: {
            nickname: {
              validators: { notEmpty: { message: '昵称不能为空' } },
            },
            account: {
              validators: { notEmpty: { message: '账号不能为空' } },
            },
            email: {
              validators: {
                notEmpty: { message: 'Email address is required' },
                emailAddress: {
                  message: 'The value is not a valid email address',
                },
              },
            },
            password: {
              validators: {
                notEmpty: { message: '密码不能为空' },
                callback: {
                  message: '密码不符合规范',
                  callback: function (e) {
                    if (e.value.length < 8) return r()
                  },
                },
              },
            },
            'confirm-password': {
              validators: {
                notEmpty: { message: '确认密码不能为空' },
                identical: {
                  compare: function () {
                    return e.querySelector('[name="password"]').value
                  },
                  message: '确认密码与上述密码不相符',
                },
              },
            },
            yqm: {
              validators: { notEmpty: { message: '邀请码不能为空' } },
            },
            toc: {
              validators: {
                notEmpty: {
                  message: '请勾选用户协议',
                },
              },
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger({
              event: { password: !1 },
            }),
            bootstrap: new FormValidation.plugins.Bootstrap5({
              rowSelector: '.fv-row',
              eleInvalidClass: '',
              eleValidClass: '',
            }),
          },
        })),
        t.addEventListener('click', function (r) {
          r.preventDefault(),
            a.revalidateField('password'),
            a.validate().then(function (a) {
              'Valid' == a
                ? (t.setAttribute('data-kt-indicator', 'on'),
                  (t.disabled = !0),
                  registerVm.register())
                : Swal.fire({
                    text: '注册失败，请检查您的输入是否有误！',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: '确认',
                    customClass: { confirmButton: 'btn btn-primary' },
                  })
            })
        }),
        e
          .querySelector('input[name="password"]')
          .addEventListener('input', function () {
            this.value.length > 0 &&
              a.updateFieldStatus('password', 'NotValidated')
          })
    },
  }
})()
KTUtil.onDOMContentLoaded(function () {
  KTSignupGeneral.init()
})

var registerVm = new Vue({
  el: '#register',
  data: {
    user: {},
  },
  methods: {
    register: function () {
      const btn = document.querySelector('#kt_sign_up_submit')
      this.$http
        .post(
          '/apisub.php?act=register',
          {
            name: this.user.name,
            user: this.user.account,
            pass: this.user.pass,
            yqm: this.user.yqm,
          },
          {
            emulateJSON: true,
          }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            closeBtnLoading(btn)
            Swal.fire({
              text: '注册成功，快去登陆吧！',
              icon: 'success',
              buttonsStyling: !1,
              confirmButtonText: '确认',
              customClass: { confirmButton: 'btn btn-primary' },
            }).then(function (t) {
              t.isConfirmed && (window.location = '/index/login')
            })
          } else {
            closeBtnLoading(btn)
            Swal.fire({
              text: data.data.msg,
              icon: 'error',
              buttonsStyling: !1,
              confirmButtonText: '确认',
              customClass: { confirmButton: 'btn btn-primary' },
            })
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
