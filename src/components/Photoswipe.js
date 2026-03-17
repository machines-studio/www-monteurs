import Barba from '@barba/core'
import PhotoSwipe from 'photoswipe'

export const selector = '.pswp'
export function hydrate (element) {
  let photoswipe
  const arrow = extractIcon('[data-svg="left"]')
  const close = extractIcon('[data-svg="close"]')

  bind()
  Barba.hooks.enter(bind)

  function bind ({ next } = {}) {
    const slides = []

    for (const image of document.body.querySelectorAll('[data-photoswipe]')) {
      const index = slides.length
      slides.push({
        index,
        element: image,
        src: image.getAttribute('data-full-src'),
        w: +image.getAttribute('data-full-width'),
        h: +image.getAttribute('data-full-height')
      })

      image.addEventListener('click', e => open(slides, index))
    }
  }

  function open (slides, index = 0) {
    photoswipe = new PhotoSwipe({
      gallery: element,

      index,
      dataSource: slides,

      wheelToZoom: true,

      bgOpacity: 1,
      paddingFn: (viewportSize, itemData, index) => ({
        top: 20,
        bottom: 20,
        left: viewportSize.x < 768 ? 20 : 100,
        right: viewportSize.x < 768 ? 20 : 100
      }),
      arrowPrevSVG: arrow,
      arrowNextSVG: arrow,
      closeSVG: close,
      zoom: false,
      counter: true,

      showHideAnimationType: 'zoom'
    })

    photoswipe.init()
  }

  function extractIcon (selector) {
    const svg = element.querySelector(selector)
    if (!svg) return
    svg.classList.add('pswp__icn')
    svg.setAttribute('aria-hidden', 'true')

    const str = svg.outerHTML
    svg.remove()

    return str
  }
}
