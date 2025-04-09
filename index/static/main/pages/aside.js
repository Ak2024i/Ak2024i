const asideVm = new Vue({
  el: '#aside',
  data: {
    activeItem: '',
    isSetItem: false,
    isAddItem: false,
  },
  methods: {
    getAsideActive: function () {
      const url = window.location.href
      const str = url.split('http://')
      const active = str[1].split('/')[2]
      this.activeItem = active
      const setArry = [
        'webset',
        'huoyuan',
        'fenlei',
        'class',
        'dengji',
        'mijia',
        'paylist',
        'data',
      ]
      // 不存在则返回 -1
      if (setArry.indexOf(active) != -1) {
        this.isSetItem = true
      }
      if (active == 'add2' || active == 'add' || active == 'addqg') {
        this.isAddItem = true
      }
    },
  },
  mounted() {
    this.getAsideActive()
  },
})
