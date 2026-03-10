export default callback => {
  let raf
  return () => {
    if (raf) window.cancelAnimationFrame(raf)
    raf = window.requestAnimationFrame(callback)
  }
}
