import { BarbaView } from '/core/Barba'

export default new BarbaView('submit', {
  beforeEnter: function ({ next }) {},
  afterEnter: function ({ next }) {
    for (const el of next.container?.querySelectorAll('textarea')) {
      el.addEventListener('input', () => {
        el.style.height = 'auto'
        el.style.height = el.scrollHeight + 'px'
      })
    }
  },
  beforeLeave: function () {},
  afterLeave: function () {}
})
