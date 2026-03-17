import noop from './noop'
import domCoords from './dom-coords-document'

export default ({
  elements,
  selector = '',
  throttler = cb => cb,
  offy = 0,
  onBreakpointEnter = noop,
  onBreakpointLeave = noop
} = {}) => {
  elements = elements || document.querySelectorAll(selector)
  if (!elements || !elements.length) return

  elements.forEach(el => {
    el.y = domCoords(el)[1]
    observe(el)
  })

  const update = throttler(() => elements.forEach(observe))
  window.addEventListener('scroll', update, false)

  return {
    destroy: () => {
      window.removeEventListener('scroll', update)
    }
  }

  function observe (element) {
    if (!element) return

    const y = window.pageYOffset
    if (element.y > y + offy) onBreakpointLeave(element, elements)
    else onBreakpointEnter(element, elements)
  }
}
