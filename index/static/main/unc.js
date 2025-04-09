const handler = setInterval(function () {
  console.clear()
  const before = new Date()
  debugger
  const after = new Date()
  const cost = after.getTime() - before.getTime()
  if (cost > 100) {
  }
}, 1)
//屏蔽右键菜单
document.oncontextmenu = function (event) {
  if (window.event) {
    event = window.event
  }
  try {
    var the = event.srcElement
    if (
      !(
        (the.tagName == 'INPUT' && the.type.toLowerCase() == 'text') ||
        the.tagName == 'TEXTAREA'
      )
    ) {
      return false
    }
    return true
  } catch (e) {
    return false
  }
}
//禁止f12
function fuckyou() {
  window.open('/', '_blank') //新窗口打开页面
  window.close() //关闭当前窗口(防抽)
  window.location = 'about:blank' //将当前窗口跳转置空白页
}
//禁止Ctrl+U
var arr = [123, 17, 18]
;(document.oncontextmenu = new Function('event.returnValue=false;')), //禁用右键
  (window.onkeydown = function (e) {
    var keyCode = e.keyCode || e.which || e.charCode
    var ctrlKey = e.ctrlKey || e.metaKey
    console.log(keyCode + '--' + keyCode)
    if (ctrlKey && keyCode == 85) {
      e.preventDefault()
    }
    if (arr.indexOf(keyCode) > -1) {
      e.preventDefault()
    }
  })
