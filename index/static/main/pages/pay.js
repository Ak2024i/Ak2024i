'use strict'
var KTCreateAccount = (function () {
  var e,
    t,
    i,
    o,
    s,
    r,
    a = []
  return {
    init: function () {
      ;(e = document.querySelector('#kt_modal_create_account')) &&
        new bootstrap.Modal(e),
        (t = document.querySelector('#kt_create_account_stepper')),
        (i = t.querySelector('#kt_create_account_form')),
        (o = t.querySelector('[data-kt-stepper-action="submit"]')),
        (s = t.querySelector('[data-kt-stepper-action="next"]')),
        (r = new KTStepper(t)).on('kt.stepper.changed', function (e) {
          3 === r.getCurrentStepIndex()
            ? (o.classList.remove('d-none'),
              o.classList.add('d-inline-block'),
              s.classList.add('d-none'))
            : 5 === r.getCurrentStepIndex()
            ? (o.classList.add('d-none'), s.classList.add('d-none'))
            : (o.classList.remove('d-inline-block'),
              o.classList.remove('d-none'),
              s.classList.remove('d-none'))
        }),
        r.on('kt.stepper.next', function (e) {
          console.log('stepper.next')
          var t = a[e.getCurrentStepIndex() - 1]
          t
            ? t.validate().then(function (t) {
                console.log('validated!'),
                  'Valid' == t
                    ? (e.goNext(), KTUtil.scrollTop())
                    : Swal.fire({
                        text: '请检查您的信息是否填写完整！',
                        icon: 'error',
                        buttonsStyling: !1,
                        confirmButtonText: '我知道了',
                        customClass: { confirmButton: 'btn btn-light' },
                      }).then(function () {
                        KTUtil.scrollTop()
                      })
              })
            : (e.goNext(), KTUtil.scrollTop())
        }),
        r.on('kt.stepper.previous', function (e) {
          console.log('stepper.previous'), e.goPrevious(), KTUtil.scrollTop()
        }),
        a.push(
          FormValidation.formValidation(i, {
            fields: {
              account_type: {
                validators: {
                  notEmpty: { message: 'Account type is required' },
                },
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
          })
        ),
        a.push(
          FormValidation.formValidation(i, {
            fields: {
              account_team_size: {
                validators: { notEmpty: { message: 'Time size is required' } },
              },
              money: {
                validators: {
                  notEmpty: { message: '支付金额不能为空' },
                },
              },
              type: {
                validators: {
                  notEmpty: { message: '请选择支付方式' },
                },
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
          })
        ),
        a.push(
          FormValidation.formValidation(i, {
            fields: {
              business_name: {
                validators: {
                  notEmpty: { message: 'Busines name is required' },
                },
              },
              business_descriptor: {
                validators: {
                  notEmpty: { message: 'Busines descriptor is required' },
                },
              },
              business_type: {
                validators: {
                  notEmpty: { message: 'Busines type is required' },
                },
              },
              business_description: {
                validators: {
                  notEmpty: { message: 'Busines description is required' },
                },
              },
              business_email: {
                validators: {
                  notEmpty: { message: 'Busines email is required' },
                  emailAddress: {
                    message: 'The value is not a valid email address',
                  },
                },
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
          })
        ),
        a.push(
          FormValidation.formValidation(i, {
            fields: {
              card_name: {
                validators: {
                  notEmpty: { message: 'Name on card is required' },
                },
              },
              card_number: {
                validators: {
                  notEmpty: { message: 'Card member is required' },
                  creditCard: { message: 'Card number is not valid' },
                },
              },
              card_expiry_month: {
                validators: { notEmpty: { message: 'Month is required' } },
              },
              card_expiry_year: {
                validators: { notEmpty: { message: 'Year is required' } },
              },
              card_cvv: {
                validators: {
                  notEmpty: { message: 'CVV is required' },
                  digits: { message: 'CVV must contain only digits' },
                  stringLength: {
                    min: 3,
                    max: 4,
                    message: 'CVV must contain 3 to 4 digits only',
                  },
                },
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
          })
        ),
        o.addEventListener('click', function (e) {
          a[0].validate().then(function (t) {
            console.log('validated!'),
              'Valid' == t
                ? (e.preventDefault(),
                  (o.disabled = !0),
                  o.setAttribute('data-kt-indicator', 'on'),
                  payVm.handlePay(),
                  setTimeout(function () {
                    payVm.toPay(),
                      o.removeAttribute('data-kt-indicator'),
                      (o.disabled = !1),
                      r.goNext()
                  }, 2e3))
                : Swal.fire({
                    text: '请检查您的信息是否填写完整！',
                    icon: 'error',
                    buttonsStyling: !1,
                    confirmButtonText: '我知道了',
                    customClass: { confirmButton: 'btn btn-light' },
                  }).then(function () {
                    KTUtil.scrollTop()
                  })
          })
        }),
        $(i.querySelector('[name="card_expiry_month"]')).on(
          'change',
          function () {
            a[3].revalidateField('card_expiry_month')
          }
        ),
        $(i.querySelector('[name="card_expiry_year"]')).on(
          'change',
          function () {
            a[3].revalidateField('card_expiry_year')
          }
        ),
        $(i.querySelector('[name="business_type"]')).on('change', function () {
          a[2].revalidateField('business_type')
        })
    },
  }
})()
KTUtil.onDOMContentLoaded(function () {
  KTCreateAccount.init()
})

const payVm = new Vue({
  el: '#pay',
  data: {
    money: '',
    out_trade_no: '',
  },
  methods: {
    handlePay: function () {
      this.$http
        .post(
          '/apisub.php?act=pay',
          { money: this.money },
          { emulateJSON: true }
        )
        .then(function (data) {
          if (data.data.code == 1) {
            this.out_trade_no = data.data.out_trade_no
            console.log('this.out_trade_no: ', this.out_trade_no)
          } else {
            toastr.error(data.data.msg)
          }
        })
    },
    toPay: function () {
      const form = document.getElementById('kt_create_account_form')
      form.submit()
    },
  },
  mounted() {},
})
