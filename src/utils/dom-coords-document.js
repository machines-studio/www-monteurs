export default el => {
  if (!el) return
  const box = el.getBoundingClientRect()

  const scroll = [
    window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
    window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
  ]

  const client = [
    document.documentElement.clientLeft || document.body.clientLeft || 0,
    document.documentElement.clientTop || document.body.clientTop || 0
  ]

  const coords = [
    box.left + scroll[0] - client[0],
    box.top + scroll[1] - client[1]
  ]

  return coords.map(Math.round)
}
