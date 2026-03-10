export const selector = '.article'

export function hydrate (element) {
  const toc = element.querySelectorAll('.article__sidebar .toc li a')

  window.addEventListener('scroll', handleScroll)
  handleScroll()

  return {
    destroy: () => {
      window.removeEventListener('scroll', handleScroll)
    }
  }

  // Highlight last found active toc entry
  function handleScroll () {
    let lastActive = null

    for (const el of toc) {
      el._target ??= element.querySelector(el.hash) // Cheap memoization

      el.classList.remove('is-active')
      if (el._target.offsetTop > document.documentElement.scrollTop + window.innerHeight * 0.25) continue
      lastActive = el
    }

    lastActive?.classList.add('is-active')
  }
}
