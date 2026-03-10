import { BarbaView } from '/core/Barba'

export default new BarbaView('search', {
  beforeEnter: function ({ next }) {},
  afterEnter: function ({ next }) {
    const input = next.container?.querySelector('.header input[type="search"]')
    input?.focus()
  },
  beforeLeave: function () {},
  afterLeave: function () {}
})
