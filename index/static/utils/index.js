// 展示按钮loading
function showBtnLoading(btn) {
  btn.setAttribute('data-kt-indicator', 'on')
  btn.disabled = !0
}

// 关闭按钮loading
function closeBtnLoading(btn) {
  btn.removeAttribute('data-kt-indicator')
  btn.disabled = !1
}
