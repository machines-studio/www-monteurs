const SELECTOR = [
  '.prose',
  '.menu__items',
  '.members__items',
  '.footer__links',
  '.footer__partners',
].join(',')

export default () => {
  for (const element of document.querySelectorAll(SELECTOR)) {
    for (const link of element.querySelectorAll('a')) {
      link.classList.add('hoverable')
      link.addEventListener('mouseenter', e => element.classList.add('has-hover'))
      link.addEventListener('mouseleave', e => element.classList.remove('has-hover'))
    }
  }
}
